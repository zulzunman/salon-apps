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
use Carbon\Carbon;

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

    /**
     * Menampilkan halaman pemilihan tanggal dan jam
     */
    public function selectDateTime(Request $request)
    {
        $serviceId = $request->query('service_id');

        // Jika tidak ada service_id, redirect ke homepage
        if (!$serviceId) {
            return redirect()->route('home-page')
                ->with('error', 'Silakan pilih layanan terlebih dahulu.');
        }

        // Validasi service exists
        $service = $this->modelService->find($serviceId);
        if (!$service) {
            return redirect()->route('home-page')
                ->with('error', 'Layanan tidak ditemukan.');
        }

        return view('customer.select-datetime', compact('service'));
    }

    /**
     * Get available times for a specific date via AJAX
     */
    public function getAvailableTimes($date)
    {
        // Validasi format tanggal
        try {
            $bookingDate = Carbon::parse($date);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        // Ambil semua waktu booking
        $allTimes = $this->modelBookingTime->orderBy('time', 'asc')->get();

        $availableTimes = [];

        foreach ($allTimes as $time) {
            // Hitung jumlah registrasi untuk tanggal dan jam ini
            $registrationCount = $this->modelRegistration
                ->where('booking_date', $bookingDate->format('Y-m-d'))
                ->where('booking_time_id', $time->id)
                ->whereIn('status', ['PENDING', 'CALLING', 'SERVING'])
                ->count();

            // Jika belum ada 3 registrasi, maka jam ini tersedia
            if ($registrationCount < 3) {
                $availableTimes[] = [
                    'id' => $time->id,
                    'time' => $time->time,
                    'remaining_slots' => 3 - $registrationCount
                ];
            }
        }

        return response()->json(['times' => $availableTimes]);
    }

    public function formRegist(Request $request)
    {
        $selectedServiceId = $request->query('service_id', null);
        $bookingDate = $request->query('booking_date');
        $bookingTimeId = $request->query('booking_time_id');

        // Validasi parameter yang diperlukan
        if (!$bookingDate || !$bookingTimeId) {
            return redirect()->route('booking.datetime')
                ->with('error', 'Silakan pilih tanggal dan jam terlebih dahulu.');
        }

        // Jika service_id tidak ada, redirect ke halaman pemilihan service
        if (!$selectedServiceId) {
            return redirect()->route('booking.datetime')
                ->with('error', 'Silakan pilih layanan terlebih dahulu.');
        }

        // Ambil data booking time untuk ditampilkan
        $bookingTime = $this->modelBookingTime->find($bookingTimeId);
        if (!$bookingTime) {
            return redirect()->route('booking.datetime')
                ->with('error', 'Jam booking tidak valid.');
        }

        // Ambil data service yang dipilih
        $selectedService = $this->modelService->find($selectedServiceId);
        if (!$selectedService) {
            return redirect()->route('booking.datetime')
                ->with('error', 'Layanan tidak valid.');
        }

        // Validasi ketersediaan slot
        $registrationCount = $this->modelRegistration
            ->where('booking_date', $bookingDate)
            ->where('booking_time_id', $bookingTimeId)
            ->whereIn('status', ['PENDING', 'CALLING', 'SERVING'])
            ->count();

        if ($registrationCount >= 3) {
            return redirect()->route('booking.datetime')
                ->with('error', 'Maaf, slot waktu yang dipilih sudah penuh. Silakan pilih waktu lain.');
        }

        return view('customer.regist', compact('selectedService', 'bookingDate', 'bookingTimeId', 'bookingTime'));
    }

    public function addData(Request $request)
    {
        // Aturan validasi
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'booking_date' => 'required|date',
            'service_id' => 'required|exists:services,id',
            'booking_time_id' => 'required|exists:booking_times,id'
        ];

        $messages = [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format yang anda masukan bukan email.',
            'booking_date.required' => 'Tanggal harus diisi.',
            'booking_date.date' => 'Format tanggal tidak valid.',
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

        // Validasi lagi ketersediaan slot sebelum menyimpan
        $registrationCount = $this->modelRegistration
            ->where('booking_date', $request->booking_date)
            ->where('booking_time_id', $request->booking_time_id)
            ->whereIn('status', ['PENDING', 'CALLING', 'SERVING'])
            ->count();

        if ($registrationCount >= 3) {
            return redirect()->route('booking.datetime')
                ->with('error', 'Maaf, slot waktu yang dipilih sudah penuh. Silakan pilih waktu lain.');
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
            return redirect()->route('home-page')
                ->with('success', 'Registrasi berhasil. Kami akan menghubungi Anda melalui email.');
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
                'bookingTime',
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

    /**
     * Memeriksa  dan memperbarui status pelanggan yang telah dipanggil tapi belum dilayani dalam 15 menit
     */
    private function checkTimedOutCalls()
    {
        $timedOutCalls = $this->modelRegistration
            ->where('status', 'CALLING')
            ->whereNotNull('called_at')
            ->where('called_at', '<=', now()->subMinutes(15))
            ->get();

        foreach ($timedOutCalls as $call) {
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
                'bookingTime',
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
