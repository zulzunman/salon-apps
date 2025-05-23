<?php

namespace App\Http\Controllers;

use App\Mail\CallingMail;
use App\Mail\CompleteMail;
use App\Mail\RegistrasiMail;
use App\Models\BookingTime;
use App\Models\Customer;
use App\Models\Registration;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    protected $modelRegistration;
    protected $modelCustomer;
    protected $modelService;
    protected $modelBookingTime;
    public function __construct()
    {
        $this->modelRegistration = new Registration();
        $this->modelCustomer = new Customer();
        $this->modelService = new Service();
        $this->modelBookingTime = new BookingTime();
    }

    public function getData(Request $request)
    {
        $status = $request->query('status');
        $query = $this->modelRegistration->with('customer', 'service', 'bookingTime');

        // Filter berdasarkan status jika ada
        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['PENDING', 'CALLING', 'SERVING']);
        }

        // Periksa pelanggan yang sudah dipanggil tapi belum dilayani lebih dari 15 menit
        $this->checkTimedOutCalls();

        $customers = $query->orderBy('booking_date', 'asc')
                        ->orderBy('booking_time_id', 'asc')
                        ->orderBy('created_at', 'asc')
                        ->get();
        return view('customer.list', compact('customers'));
    }

    public function formRegist(Request $request)
    {
        $services = $this->modelService->all();
        $times = $this->modelBookingTime->all();
        $selectedServiceId = $request->query('service_id', null);

        return view('customer.regist', compact('services', 'times', 'selectedServiceId'));
    }

    public function addData(Request $request)
    {
        // Aturan validasi
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'booking_date' => 'required',
            'service_id' => 'required|exists:services,id',
            'booking_time_id' => 'required|exists:booking_times,id'
        ];

        $messages = [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format yang anda masukan bukan email.',
            'booking_date.required' => 'Tanggal harus diisi.',
            'service_id.required' => 'Silakan pilih pelayanan yang akan dilakukan.',
            'booking_time_id.required' => 'Silakan pilih jam pelayanan yang akan dilakukan.',
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $customer = $this->modelCustomer;
            $customer->name = $request->input('name');
            $customer->email = $request->input('email');
            $customer->save();

            $register = $this->modelRegistration;
            $register->customer_id = $customer->id;
            $register->service_id = $request->input('service_id');
            $register->booking_time_id = $request->input('booking_time_id');
            $register->booking_date = $request->input('booking_date');
            $register->status = "PENDING";
            $register->save();

            $data = $this->modelRegistration->with([
                'customer',
                'service',
                'bookingTime',
            ])->find($register->id);

            Mail::to($customer->email)->send(new RegistrasiMail($data));

            DB::commit();
            // Ubah redirect ke home-page dengan pesan sukses
            return redirect()->route('home-page')
                ->with('success', 'Registrasi berhasil. Kami akan menghubungi Anda melalui email.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput() // biar data form tidak hilang
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
                'bookingTime',
            ])->find($id);

            Mail::to($dataCustomer->customer->email)->send(new CallingMail($dataCustomer));

            DB::commit();
            return redirect()->route('register.get-data')
                ->with('success', 'Memanggil pelanggan berhasil.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput() // biar data form tidak hilang
                ->withErrors(['message' => 'Terjadi kesalahan saat pemanggilan pelanggan: ' . $e->getMessage()]);
        }
    }

    /**
     * Memeriksa dan memperbarui status pelanggan yang telah dipanggil tapi belum dilayani dalam 15 menit
     */
    private function checkTimedOutCalls()
    {
        // Cari registrasi dengan status 'CALLING' yang called_at-nya lebih dari 15 menit yang lalu
        $timedOutCalls = $this->modelRegistration
            ->where('status', 'CALLING')
            ->whereNotNull('called_at')
            ->where('called_at', '<=', now()->subMinutes(15))
            ->get();

        foreach ($timedOutCalls as $call) {
            // Update status menjadi 'CANCELED' sesuai kebutuhan
            // Kita pilih PENDING agar bisa dipanggil ulang
            $call->status = 'CANCELED';
            $call->save();
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
                ->withInput() // biar data form tidak hilang
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
                'bookingTime',
            ])->find($id);

            Mail::to($dataCustomer->customer->email)->send(new CompleteMail($dataCustomer));

            DB::commit();
            return redirect()->route('register.get-data')
                ->with('success', 'Pelayanan selesai.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput() // biar data form tidak hilang
                ->withErrors(['message' => 'Terjadi kesalahan saat update status pelanggan: ' . $e->getMessage()]);
        }
    }
}
