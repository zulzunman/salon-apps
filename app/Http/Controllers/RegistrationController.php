<?php

namespace App\Http\Controllers;

use App\Mail\CallingMail;
use App\Mail\CancleMail;
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

        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['PENDING', 'CALLING', 'SERVING']);
        }

        $this->checkTimedOutCalls();
        $customers = $query->orderBy('booking_date', 'asc')
            ->orderBy('booking_time_id', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('customer.list', compact('customers'));
    }

    public function selectDateTime(Request $request)
    {
        $selectedServiceId = $request->query('service_id');
        $selectedMonth = $request->query('month');
        $selectedDate = $request->query('date');

        if (!$selectedServiceId) {
            return redirect()->route('home-page')
                ->with('error', 'Silakan pilih layanan terlebih dahulu.');
        }

        $service = $this->modelService->find($selectedServiceId);
        if (!$service) {
            return redirect()->route('home-page')
                ->with('error', 'Layanan tidak ditemukan.');
        }

        // Handle month navigation
        $currentDate = $selectedMonth ? Carbon::parse($selectedMonth . '-01') : Carbon::now();
        $prevMonth = $currentDate->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentDate->copy()->addMonth()->format('Y-m');
        $currentMonthName = $this->getIndonesianMonth($currentDate->month) . ' ' . $currentDate->year;

        // Generate calendar days
        $calendarDays = $this->generateCalendarDays($currentDate);

        // Get available times if date is selected
        $availableTimes = [];
        $selectedTimeId = null;
        if ($selectedDate) {
            $availableTimes = $this->getAvailableTimesForDate($selectedDate);
        }

        // Pass current time to view for real-time checking
        $currentTime = Carbon::now()->format('H:i:s');
        $currentDate = Carbon::now()->format('Y-m-d');

        return view('customer.select-datetime', compact(
            'service',
            'selectedServiceId',
            'calendarDays',
            'currentMonthName',
            'prevMonth',
            'nextMonth',
            'selectedDate',
            'availableTimes',
            'selectedTimeId',
            'currentTime',
            'currentDate'
        ));
    }

    private function generateCalendarDays($currentDate)
    {
        $days = [];
        $today = Carbon::now()->startOfDay();

        // Get first day of month and calculate starting point
        $firstDay = $currentDate->copy()->startOfMonth();
        $startDate = $firstDay->copy()->startOfWeek(Carbon::SUNDAY);

        // Generate 42 days (6 weeks)
        for ($i = 0; $i < 42; $i++) {
            $date = $startDate->copy()->addDays($i);

            $class = '';
            $selectable = false;

            if ($date->month !== $currentDate->month) {
                $class = 'other-month';
            } elseif ($date->lt($today)) {
                $class = 'disabled';
            } else {
                $selectable = true;
                if ($date->isSameDay($today)) {
                    $class = 'today';
                }
            }

            $days[] = [
                'number' => $date->day,
                'date' => $date->format('Y-m-d'),
                'class' => $class,
                'selectable' => $selectable
            ];
        }

        return $days;
    }

    private function getIndonesianMonth($month)
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $months[$month];
    }

    private function getAvailableTimesForDate($date)
    {
        try {
            $bookingDate = Carbon::parse($date);
        } catch (\Exception $e) {
            return [];
        }

        $allTimes = $this->modelBookingTime->orderBy('time', 'asc')->get();
        $availableTimes = [];
        $now = Carbon::now();
        $isToday = $bookingDate->isToday();

        foreach ($allTimes as $time) {
            $registrationCount = $this->modelRegistration
                ->where('booking_date', $bookingDate->format('Y-m-d'))
                ->where('booking_time_id', $time->id)
                ->whereIn('status', ['PENDING', 'CALLING', 'SERVING'])
                ->count();

            // Check if time has passed for today
            $isPastTime = false;
            if ($isToday) {
                // Parse the time string (assuming format like "09:00")
                $timeArray = explode(':', $time->time);
                $bookingDateTime = $bookingDate->copy()
                    ->setHour((int)$timeArray[0])
                    ->setMinute((int)$timeArray[1])
                    ->setSecond(0);

                $isPastTime = $bookingDateTime->lt($now);
            }

            // Include all times but mark past ones appropriately
            $availableTimes[] = [
                'id' => $time->id,
                'time' => $time->time,
                'remaining_slots' => 3 - $registrationCount,
                'is_past' => $isPastTime,
                'is_full' => $registrationCount >= 3,
                'can_select' => !$isPastTime && $registrationCount < 3
            ];
        }

        return $availableTimes;
    }

    // Keep the original AJAX method for backward compatibility if needed
    public function getAvailableTimes($date)
    {
        $availableTimes = $this->getAvailableTimesForDate($date);
        return response()->json([
            'times' => $availableTimes,
            'current_time' => Carbon::now()->format('H:i:s'),
            'current_date' => Carbon::now()->format('Y-m-d')
        ]);
    }

    // Add method for real-time time checking via AJAX
    public function checkCurrentTime()
    {
        return response()->json([
            'current_time' => Carbon::now()->format('H:i:s'),
            'current_date' => Carbon::now()->format('Y-m-d')
        ]);
    }

    public function formRegist(Request $request)
    {
        $selectedServiceId = $request->query('service_id', null);
        $bookingDate = $request->query('booking_date');
        $bookingTimeId = $request->query('booking_time_id');

        if (!$bookingDate || !$bookingTimeId) {
            return redirect()->route('booking.datetime', ['service_id' => $selectedServiceId])
                ->with('error', 'Silakan pilih tanggal dan jam terlebih dahulu.');
        }

        if (!$selectedServiceId) {
            return redirect()->route('booking.datetime')
                ->with('error', 'Silakan pilih layanan terlebih dahulu.');
        }

        $bookingTime = $this->modelBookingTime->find($bookingTimeId);
        if (!$bookingTime) {
            return redirect()->route('booking.datetime', ['service_id' => $selectedServiceId])
                ->with('error', 'Jam booking tidak valid.');
        }

        $selectedService = $this->modelService->find($selectedServiceId);
        if (!$selectedService) {
            return redirect()->route('booking.datetime')
                ->with('error', 'Layanan tidak valid.');
        }

        // Check availability again
        $registrationCount = $this->modelRegistration
            ->where('booking_date', $bookingDate)
            ->where('booking_time_id', $bookingTimeId)
            ->whereIn('status', ['PENDING', 'CALLING', 'SERVING'])
            ->count();

        if ($registrationCount >= 3) {
            return redirect()->route('booking.datetime', ['service_id' => $selectedServiceId])
                ->with('error', 'Maaf, slot waktu yang dipilih sudah penuh. Silakan pilih waktu lain.');
        }

        return view('customer.regist', compact('selectedService', 'bookingDate', 'bookingTimeId', 'bookingTime'));
    }

    // Rest of the methods remain the same...
    public function addData(Request $request)
    {
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

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Double-check availability
        $registrationCount = $this->modelRegistration
            ->where('booking_date', $request->booking_date)
            ->where('booking_time_id', $request->booking_time_id)
            ->whereIn('status', ['PENDING', 'CALLING', 'SERVING'])
            ->count();

        if ($registrationCount >= 3) {
            return redirect()->route('booking.datetime', ['service_id' => $request->service_id])
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

    private function checkTimedOutCalls()
    {
        $timedOutCalls = $this->modelRegistration->with([
            'customer',
            'service',
            'bookingTime',
        ])
            ->where('status', 'CALLING')
            ->whereNotNull('called_at')
            ->where('called_at', '<=', now()->subMinutes(15))
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
