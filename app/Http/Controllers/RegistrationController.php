<?php

namespace App\Http\Controllers;

use App\Jobs\SendReminderEmailJob;
use App\Mail\CallingMail;
use App\Mail\CancleMail;
use App\Mail\CompleteMail;
use App\Mail\RegistrasiMail;
use App\Mail\ReminderMail;
use App\Models\Customer;
use App\Models\Registration;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    protected $modelRegistration;
    protected $modelCustomer;
    protected $modelService;

    public function __construct()
    {
        $this->modelRegistration = new Registration();
        $this->modelCustomer = new Customer();
        $this->modelService = new Service();
    }

    public function getData(Request $request)
    {

        $status = $request->query('status');
        $perPage = $request->query('per_page', 10);

        $query = $this->modelRegistration->with('customer', 'service');

        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['PENDING', 'CALLING', 'SERVING']);
        }

        $this->checkTimedOutCalls();

        $customers = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // Preserve query parameters in pagination links
        $customers->appends($request->query());

        return view('customer.list', compact('customers'));
    }

    public function formRegist(Request $request)
    {
        $selectedServiceId = $request->query('service_id', null);

        if (!$selectedServiceId) {
            return redirect()->route('home-page')
                ->with('error', 'Silakan pilih layanan terlebih dahulu.');
        }

        $selectedService = $this->modelService->find($selectedServiceId);
        if (!$selectedService) {
            return redirect()->route('home-page')
                ->with('error', 'Layanan tidak valid.');
        }

        // Hitung nomor antrean untuk hari ini
        $queueNumber = $this->modelRegistration
            ->whereDate('created_at', now()->toDateString())
            ->count() + 1;

        $antrianSebelumnya = Registration::whereDate('created_at', now()->toDateString())
            ->where('queue_number', '<', $queueNumber)
            ->where('status', '!=', 'COMPLETED') // ← Tambahan untuk exclude selesai
            ->orderBy('queue_number')
            ->get();

        return view('customer.regist', compact('selectedService', 'queueNumber', 'antrianSebelumnya'));
    }


    public function addData(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'service_id' => 'required|exists:services,id',
        ];

        $messages = [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format yang anda masukan bukan email.',
            'service_id.required' => 'Silakan pilih pelayanan yang akan dilakukan.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Simpan customer
            $customer = $this->modelCustomer;
            $customer->name = $request->input('name');
            $customer->email = $request->input('email');
            $customer->save();

            // Hitung nomor antrean untuk hari ini
            $queueNumber = $this->modelRegistration
                ->whereDate('created_at', now()->toDateString())
                ->count();

            // Simpan registrasi
            $register = $this->modelRegistration;
            $register->customer_id = $customer->id;
            $register->service_id = $request->input('service_id');
            $register->status = "PENDING";
            $register->queue_number = $queueNumber + 1;
            $register->save();

            // Kirim email
            $data = $this->modelRegistration->with([
                'customer',
                'service',
            ])->find($register->id);

            Mail::to($customer->email)->send(new RegistrasiMail($data));

            DB::commit();
            return redirect()->route('home-page')
                ->with('success', 'Registrasi berhasil. Nomor antrean Anda: ' . ($queueNumber + 1));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function callCustomer($id)
    {
        $data = $this->modelRegistration->findOrFail($id);
        DB::beginTransaction();
        try {
            $data->status = "CALLING";
            $data->called_at = now();
            $data->save();

            $dataCustomer = $this->modelRegistration->with([
                'customer',
                'service',
            ])->find($id);

            Mail::to($dataCustomer->customer->email)->send(new CallingMail($dataCustomer));

            DB::commit();
            return redirect()->route('register.get-data')
                ->with('success', 'Memanggil pelanggan berhasil.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['message' => 'Terjadi kesalahan saat pemanggilan pelanggan: ' . $e->getMessage()]);
        }
    }

    private function checkTimedOutCalls()
    {
        $timedOutCalls = $this->modelRegistration->with([
            'customer',
            'service',
        ])
            ->where('status', 'CALLING')
            ->whereNotNull('called_at')
            ->where('called_at', '<=', now()->subMinutes(30))
            ->get();

        foreach ($timedOutCalls as $call) {
            $call->status = 'CANCELED';
            $call->save();
            Mail::to($call->customer->email)->send(new CancleMail($call));
        }
    }

    public function servingCustomer($id)
    {
        $data = $this->modelRegistration->findOrFail($id);
        DB::beginTransaction();
        try {
            $data->status = "SERVING";
            $data->save();
            DB::commit();
            return redirect()->route('register.get-data')
                ->with('success', 'Pelanggan sedang dilayani.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['message' => 'Terjadi kesalahan saat update status pelanggan: ' . $e->getMessage()]);
        }
    }

    public function completeCustomer($id)
    {
        $data = $this->modelRegistration->findOrFail($id);
        DB::beginTransaction();
        try {
            $data->status = "COMPLETED";
            $data->save();

            $dataCustomer = $this->modelRegistration->with([
                'customer',
                'service',
            ])->find($id);

            Mail::to($dataCustomer->customer->email)->send(new CompleteMail($dataCustomer));

            DB::commit();
            return redirect()->route('register.get-data')
                ->with('success', 'Pelayanan selesai.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['message' => 'Terjadi kesalahan saat update status pelanggan: ' . $e->getMessage()]);
        }
    }
}
