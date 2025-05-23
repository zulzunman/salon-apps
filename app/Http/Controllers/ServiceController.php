<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    protected $model;
    public function __construct()
    {
        $this->model = new Service();
    }
    public function getData()
    {
        $services = $this->model->all();

        return view('admin.service.list', compact('services'));
    }

    public function formAdd()
    {
        return view('admin.service.create');
    }

    public function addData(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|numeric'
        ];

        $messages = [
            'name.required' => 'Nama layanan harus di isi.',
            'description.required' => 'Deskripsi layanan harus di isi.',
            'price.required' => 'Harga layanan harus di isi.',
            'duration.required' => 'Waktu pelayanan harus di isi.',
            'price.numeric' => 'Data yang diinputkan berupa angka.',
            'duration.numeric' => 'Data yang diinputkan berupa angka.',
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
            $data->description = $request->input('description');
            $data->price = $request->input('price');
            $data->duration = $request->input('duration');
            $data->save();

            DB::commit();

            return redirect()->route('service.get-data')
                ->with('success', 'Pelayanan berhasil ditambahkan.')
                ->with('data', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput() // biar data form tidak hilang
                ->withErrors(['message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function formEdit($id)
    {
        $service = $this->model->findOrFail($id);
        return view('admin.service.edit', compact('service'));
    }

    public function editData(Request $request, $id)
    {
        $service = $this->model->findOrFail($id);

        $rules = [
            'name'  => 'sometimes',
            'description'  => 'sometimes',
            'price' => 'sometimes|numeric',
            'duration'  => 'sometimes|numeric',
        ];

        $messages = [
            'price.numeric' => 'Data yang diinputkan berupa angka.',
            'duration.numeric' => 'Data yang diinputkan berupa angka.',
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
            // Update data sesuai input yang diberikan
            if ($request->has('name')) {
                $service->name = $request->name;
            }
            if ($request->has('description')) {
                $service->description = $request->description;
            }
            if ($request->has('price')) {
                $service->price = $request->price;
            }
            if ($request->has('duration')) {
                $service->duration = $request->duration;
            }
            $service->save();

            DB::commit();

            return redirect()->route('service.get-data')->with('success', 'Pelayanan berhasil diedit.');
        } catch (\Exception $e) {
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
            return redirect()->route('service.get-data')
                ->with('success', 'Data pelayanan berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput() // biar data form tidak hilang
                ->withErrors(['message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()]);
        }
    }
}
