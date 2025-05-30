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

    // Method untuk homepage (menampilkan services di halaman utama)
    public function getServicesForHomepage()
    {
        $services = $this->model->all();
        return view('homepage', compact('services'));
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:1'
        ];

        $messages = [
            'name.required' => 'Nama layanan harus diisi.',
            'description.required' => 'Deskripsi layanan harus diisi.',
            'price.required' => 'Harga layanan harus diisi.',
            'duration.required' => 'Waktu pelayanan harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'duration.numeric' => 'Durasi harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'duration.min' => 'Durasi minimal 1 menit.',
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
            $data = new Service(); // Perbaikan: gunakan new Service() bukan $this->model
            $data->name = $request->input('name');
            $data->description = $request->input('description');
            $data->price = $request->input('price');
            $data->duration = $request->input('duration');
            $data->save();

            DB::commit();

            return redirect()->route('service.get-data')
                ->with('success', 'Pelayanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:1',
        ];

        $messages = [
            'name.required' => 'Nama layanan harus diisi.',
            'description.required' => 'Deskripsi layanan harus diisi.',
            'price.required' => 'Harga layanan harus diisi.',
            'duration.required' => 'Waktu pelayanan harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'duration.numeric' => 'Durasi harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'duration.min' => 'Durasi minimal 1 menit.',
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // PERBAIKAN: Gunakan redirect biasa, bukan concatenation string
            return redirect()->route('service.get-data')
                ->withErrors($validator)
                ->withInput()
                ->with('edit_error_service_id', $id);
        }

        DB::beginTransaction();
        try {
            // Update data
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->duration = $request->duration;
            $service->save();

            DB::commit();

            return redirect()->route('service.get-data')
                ->with('success', 'Pelayanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            // PERBAIKAN: Gunakan redirect biasa
            return redirect()->route('service.get-data')
                ->withInput()
                ->withErrors(['message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()])
                ->with('edit_error_service_id', $id);
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
                ->withInput()
                ->withErrors(['message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()]);
        }
    }
}
