<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        // Ambil semua user dengan role 'staff'
        $data = $this->model->where('role', 'STAFF')->get();

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
            $data->role = 'STAFF';
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

            return redirect()->route('admin.staff.index')
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
            'email'  =>  'required|email|unique:users,email,' . $id, // Exclude current user from unique validation
            'password'  =>  [
                'nullable', // Password optional untuk edit
                'confirmed',
                'min:8',
            ],
        ];

        $messages = [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Silahkan isi dengan alamat email yang valid',
            'email.unique' => 'Email sudah digunakan',
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

            // Update password hanya jika diisi
            if ($request->filled('password')) {
                $data->password = Hash::make($request->password); // Fix: gunakan $request->password, bukan $request->name
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

            return redirect()->route('admin.staff.index')
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
        $data = $this->model->findOrFail($id);

        DB::beginTransaction();
        try {
            $data->delete();

            DB::commit();
            return redirect()->route('admin.staff.index')
                ->with('success', 'Data staff berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()]);
        }
    }
}
