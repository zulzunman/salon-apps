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
    public function __construct() {
        $this->modelRegistration = new Registration();
        $this->modelCustomer = new Customer();
        $this->modelService = new Service();
        $this->modelBookingTime = new BookingTIme();
    }
    public function getData()
    {
        $customers = $this->modelRegistration->with('customer', 'service')
                        ->whereIn('status', ['PENDING', 'CALLING', 'SERVING'])
                        ->orderBy('queue_number', 'asc')
                        ->get();

        return view('customer.list', compact('customers'));
    }

    public function formRegist()
    {
        $services = $this->modelService->all();
        $times = $this->modelBookingTime->all();
        return view('customer.regist', compact('services, times'));
    }
    public function addData(Request $request)
    {
        // Aturan validasi
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'service_id' => 'required|exists:services,id',
            'booking_time_id' => 'required|exists:booking_times,id'
        ];

        $messages = [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format yang anda masukan bukan email.',
            'service_id.required' => 'Silakan pilih pelayanan yang akan dilakukan.',
            'booking_time_id.required' => 'Silakan pilih jam pelayanan yang akan dilakukan.',
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 400); // 400 Bad Request
        }

        DB::beginTransaction();
        try {
            $customer = $this->modelCustomer;
            $customer->name = $request->input('name');
            $customer->email = $request->input('email');
            $customer->save();

            $register = new $this->modelRegistration;
            $register->customer_id = $customer->id;
            $register->service_id = $request->input('service_id');
            $register->booking_time_id = $request->input('booking_time_id');
            $register->status = "PENDING";
            $register->save();

            $data = $this->modelRegistration->with([
                'registration.customer',
                'registration.service',
                'registration.bookingTime',
            ])->first();

            Mail::to($customer->email)->send(new RegistrasiMail($data));

            DB::commit();
            return redirect()->route('register.get-data')
                            ->with('success', 'Registrasi berhasil.')
                            ->with('data', $register);
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
                'registration.customer',
                'registration.service',
                'registration.bookingTime',
            ])->first();

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
                'registration.customer',
                'registration.service',
                'registration.bookingTime',
            ])->first();

            Mail::to($dataCustomer->customer->email)->send(new CompleteMail($dataCustomer));

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
}
