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
        return view('admin.staff.form-add', compact('data'));
    }

    public function addData(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ];

        $messages = [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Silahkan isi dengan alaman email',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Password konfirmasi salah',
            'password.min' => 'Password minimal 8 digit',
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
            $data = $this->model;
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->role = 'STAFF';
            $data->password = Hash::make($request->input('password'));
            $data->save();

            DB::commit();
            return redirect()->route('admin.staff.index')
                            ->with('success', 'Tambah data staff berhasil.')
                            ->with('data', $data);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                            ->withInput() // biar data form tidak hilang
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
            'name'  =>  'sometimes',
            'email'  =>  'sometimes|email',
            'password'  =>  [
                'sometimes',
                'confirmed',
                'min:8',
            ],
        ];

        $messages = [
            'email.email' => 'Silahkan isi dengan alaman email',
            'password.confirmed' => 'Password konfirmasi salah',
            'password.min' => 'Password minimal 8 digit',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 400); // 400 Bad Request
        }

        DB::beginTransaction();
        try {
            // Update data sesuai input yang diberikan
            if ($request->has('name')) {
                $data->name = $request->name;
            }
            if ($request->has('email')) {
                $data->email = $request->email;
            }
            if ($request->has('password')) {
                $data->password = Hash::make($request->name);
            }
            $data->save();

            DB::commit();
            return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil diedit.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                            ->withInput() // biar data form tidak hilang
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
                        ->with('success', 'Data pelayanan berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                            ->withInput() // biar data form tidak hilang
                            ->withErrors(['message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()]);
        }
    }
}
