<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function getData()
    {
        // Ambil user dengan role 'STAFF' dengan pagination
        $data = $this->model->where('role', 'STAFF')->paginate(5);

        return view('admin.staff.index', compact('data'));
    }

    public function formAdd()
    {
        $data = $this->model->where('role', 'STAFF')->get();
        return view('admin.staff.formAdd', compact('data'));
    }

    public function addData(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:STAFF,CASHIER', // PERUBAHAN: Tambahkan validasi role
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ];

        $messages = [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Silahkan isi dengan alamat email yang valid',
            'email.unique' => 'Email sudah digunakan',
            'role.required' => 'Role akses harus diisi',
            'role.in' => 'Role harus STAFF atau CASHIER', // PERUBAHAN: Tambahkan pesan error role
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Password konfirmasi tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Untuk AJAX request, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => $validator->errors()
                ], 400);
            }

            // Untuk form biasa, redirect back dengan errors
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $data = new User(); // Gunakan new instance, bukan $this->model
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->role = $request->input('role');
            $data->password = Hash::make($request->input('password'));
            $data->save();

            DB::commit();

            // Untuk AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Staff berhasil ditambahkan'
                ]);
            }

            return redirect()->route('staff.get-data')
                ->with('success', 'Tambah data staff berhasil.');
        } catch (Exception $e) {
            DB::rollBack();

            // Untuk AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function formEdit($id)
    {
        $data = $this->model->findOrFail($id);

        return view('admin.staff.formEdit', compact('data'));
    }

    public function editData(Request $request, $id)
    {
        $data = $this->model->findOrFail($id);

        $rules = [
            'name'  =>  'required',
            'email'  =>  'required|email|unique:users,email,' . $id,
            'role'  =>  'required|in:STAFF,CASHIER', // PERUBAHAN: Tambahkan validasi role
            'password'  =>  [
                'nullable',
                'confirmed',
                'min:8',
            ],
        ];

        $messages = [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Silahkan isi dengan alamat email yang valid',
            'email.unique' => 'Email sudah digunakan',
            'role.required' => 'Role akses harus diisi',
            'role.in' => 'Role harus STAFF atau CASHIER', // PERUBAHAN: Tambahkan pesan error role
            'password.confirmed' => 'Password konfirmasi tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Untuk AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => $validator->errors()
                ], 400);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Update data
            $data->name = $request->name;
            $data->email = $request->email;
            $data->role = $request->role;
            // Update password hanya jika diisi
            if ($request->filled('password')) {
                $data->password = Hash::make($request->password);
            }

            $data->save();

            DB::commit();

            // Untuk AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Staff berhasil diupdate'
                ]);
            }

            return redirect()->route('staff.get-data')
                ->with('success', 'Staff berhasil diedit.');
        } catch (Exception $e) {
            DB::rollBack();

            // Untuk AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['message' => 'Terjadi kesalahan saat edit data: ' . $e->getMessage()]);
        }
    }

    public function deleteData($id)
    {
        try {
            $staff = User::where('role', 'STAFF')->findOrFail($id);

            DB::beginTransaction();

            // Optional: Check if staff has related registrations
            // Uncomment if you have registrations relationship
            // $hasRegistrations = $staff->registrations()->exists();
            // 
            // if ($hasRegistrations) {
            //     DB::rollBack();
            //     return redirect()->back()
            //         ->with('error', 'Staff tidak dapat dihapus karena memiliki data registrasi pelanggan.');
            // }

            // Delete the staff
            $staffName = $staff->name;
            $staff->delete();

            DB::commit();

            return redirect()->route('staff.get-data')
                ->with('success', "Data staff '{$staffName}' berhasil dihapus");
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Data staff tidak ditemukan');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting staff: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data staff. Silakan coba lagi.');
        }
    }

    public function reportings(Request $request)
    {
        // Perbaiki query untuk role - konsisten dengan method lain
        $staffList = User::where('role', 'STAFF')->get();
        $staffId = $request->input('staff_id');
        $viewType = $request->input('view_type', 'daily');

        // Default ke tanggal hari ini alih-alih sebulan penuh
        $selectedDate = $request->input('selected_date', date('j')); // hari saat ini (1-31)
        $selectedMonth = $request->input('selected_month', date('n')); // bulan saat ini (1-12)
        $selectedYear = $request->input('selected_year', date('Y')); // tahun saat ini

        // Jika tidak ada filter khusus, default tampilkan data hari ini saja
        $isDefaultView = !$request->has('staff_id') && !$request->has('view_type') &&
            !$request->has('selected_date') && !$request->has('selected_month') &&
            !$request->has('selected_year');

        // Base query untuk staff - perbaiki role
        $query = User::where('role', 'STAFF');
        if ($staffId) {
            $query->where('id', $staffId);
        }
        $staffData = $query->get();

        // Prepare report data
        $reportData = [];

        foreach ($staffData as $staff) {
            if ($viewType === 'daily') {
                if ($selectedDate && ($isDefaultView || $request->has('selected_date'))) {
                    // Hitung untuk tanggal spesifik (default: hari ini)
                    $count = $staff->registrations()
                        ->whereYear('registrations.created_at', $selectedYear)
                        ->whereMonth('registrations.created_at', $selectedMonth)
                        ->whereDay('registrations.created_at', $selectedDate)
                        ->where('registrations.status', 'COMPLETED') // Filter hanya COMPLETED
                        ->count();

                    $reportData[$staff->id] = [
                        'staff_name' => $staff->name,
                        'data' => [$selectedDate => $count],
                        'total' => $count
                    ];
                } else {
                    // Hitung untuk semua hari dalam bulan
                    $dailyData = [];
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);

                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        $count = $staff->registrations()
                            ->whereYear('registrations.created_at', $selectedYear)
                            ->whereMonth('registrations.created_at', $selectedMonth)
                            ->whereDay('registrations.created_at', $day)
                            ->where('registrations.status', 'COMPLETED') // Filter hanya COMPLETED
                            ->count();

                        $dailyData[$day] = $count;
                    }

                    $reportData[$staff->id] = [
                        'staff_name' => $staff->name,
                        'data' => $dailyData,
                        'total' => array_sum($dailyData)
                    ];
                }
            } elseif ($viewType === 'weekly') {
                $weeklyData = [];
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
                $weekCount = ceil($daysInMonth / 7);

                for ($week = 1; $week <= $weekCount; $week++) {
                    $startDay = ($week - 1) * 7 + 1;
                    $endDay = min($week * 7, $daysInMonth);

                    // Query untuk rentang hari dalam minggu
                    $count = $staff->registrations()
                        ->whereYear('registrations.created_at', $selectedYear)
                        ->whereMonth('registrations.created_at', $selectedMonth)
                        ->whereBetween(DB::raw('DAY(registrations.created_at)'), [$startDay, $endDay])
                        ->where('registrations.status', 'COMPLETED') // Filter hanya COMPLETED
                        ->count();

                    $weeklyData[$week] = [
                        'count' => $count,
                        'range' => "$startDay-$endDay"
                    ];
                }

                $reportData[$staff->id] = [
                    'staff_name' => $staff->name,
                    'data' => $weeklyData,
                    'total' => array_sum(array_column($weeklyData, 'count'))
                ];
            } elseif ($viewType === 'monthly') {
                $monthlyData = [];

                for ($month = 1; $month <= 12; $month++) {
                    $count = $staff->registrations()
                        ->whereYear('registrations.created_at', $selectedYear)
                        ->whereMonth('registrations.created_at', $month)
                        ->where('registrations.status', 'COMPLETED') // Filter hanya COMPLETED
                        ->count();

                    $monthlyData[$month] = $count;
                }

                $reportData[$staff->id] = [
                    'staff_name' => $staff->name,
                    'data' => $monthlyData,
                    'total' => array_sum($monthlyData)
                ];
            }
        }

        // Generate options
        $dateOptions = range(1, cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear));
        $monthOptions = [
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
        $yearOptions = range(date('Y') - 5, date('Y') + 1);

        // Untuk default view, set selectedDate agar tampil di form
        if ($isDefaultView) {
            $selectedDate = date('j');
        }

        return view('admin.staff.report', compact(
            'reportData',
            'staffList',
            'staffId',
            'viewType',
            'selectedDate',
            'selectedMonth',
            'selectedYear',
            'dateOptions',
            'monthOptions',
            'yearOptions'
        ));
    }
}
