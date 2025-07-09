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
        $services = $this->model->paginate(5); // 5 data per halaman
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
            'price' => 'required|numeric|digits_between:1,7',
            'duration' => 'required|numeric|min:1',
            'picture' => 'nullable|image|mimes:jpeg,jpg,png|max:10240', // max 10MB
        ];

        $messages = [
            'name.required' => 'Nama layanan harus diisi.',
            'description.required' => 'Deskripsi layanan harus diisi.',
            'price.required' => 'Harga layanan harus diisi.',
            'duration.required' => 'Waktu pelayanan harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'duration.numeric' => 'Durasi harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'price.digits_between' => 'Harga tidak boleh lebih dari 7 digit.',
            'duration.min' => 'Durasi minimal 1 menit.',
            'picture.image' => 'File harus berupa gambar.',
            'picture.mimes' => 'Gambar hanya boleh dalam format jpeg, jpg, atau png.',
            'picture.max' => 'Ukuran gambar maksimal 10 MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $data = new Service();
            $data->name = $request->input('name');
            $data->description = $request->input('description');
            $data->price = $request->input('price');
            $data->duration = $request->input('duration');
            $data->save(); // disimpan dulu agar mendapatkan ID

            // Proses upload gambar jika ada
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $extension = $file->getClientOriginalExtension();
                $fileName = $data->id . '-' . str_replace(' ', '_', strtolower($data->name)) . '.' . $extension;

                $destinationPath = public_path('assets/img/service');
                $file->move($destinationPath, $fileName);

                // Simpan nama file ke kolom picture (jika tersedia di tabel)
                $data->picture = $fileName;
                $data->save();
            }

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
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|digits_between:1,7',
            'duration' => 'sometimes|numeric|min:1',
            'picture' => 'nullable|image|mimes:jpeg,jpg,png|max:10240', // max 10MB
        ];

        $messages = [
            'price.numeric' => 'Harga harus berupa angka.',
            'duration.numeric' => 'Durasi harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'price.digits_between' => 'Harga tidak boleh lebih dari 7 digit.',
            'duration.min' => 'Durasi minimal 1 menit.',
            'picture.image' => 'File harus berupa gambar.',
            'picture.mimes' => 'Gambar hanya boleh dalam format jpeg, jpg, atau png.',
            'picture.max' => 'Ukuran gambar maksimal 10 MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('service.get-data')
                ->withErrors($validator)
                ->withInput()
                ->with('edit_error_service_id', $id);
        }

        DB::beginTransaction();
        try {
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

            // Proses upload gambar jika ada
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $extension = $file->getClientOriginalExtension();
                $fileName = $service->id . '-' . str_replace(' ', '_', strtolower($service->name)) . '.' . $extension;

                $destinationPath = public_path('assets/img/service');

                // Hapus file lama jika ada
                if (!empty($service->picture) && file_exists($destinationPath . '/' . $service->picture)) {
                    unlink($destinationPath . '/' . $service->picture);
                }

                // Upload file baru
                $file->move($destinationPath, $fileName);

                $service->picture = $fileName;
            }

            $service->save();

            DB::commit();

            return redirect()->route('service.get-data')
                ->with('success', 'Pelayanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
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
            // Hapus file jika ada
            if ($data->picture && file_exists(public_path('assets/img/service/' . $data->picture))) {
                unlink(public_path('assets/img/service/' . $data->picture));
            }
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
