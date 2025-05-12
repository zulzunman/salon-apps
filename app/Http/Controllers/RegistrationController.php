<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Registration;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function getData()
    {
        $customers = Registration::with('customer', 'service')
                        ->whereIn('status', ['PENDING', 'CALLING', 'SERVING'])
                        ->orderBy('queue_number', 'asc')
                        ->get();

        return view('customer.list', compact('customers'));
    }

    public function formRegist()
    {
        $services = Service::all();
        return view('customer.regist', compact('services'));
    }
    public function addData(Request $request)
    {
        // Aturan validasi
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'service_id' => 'required|exists:services,id'
        ];

        $messages = [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format yang anda masukan bukan email.',
            'service_id.required' => 'Silakan pilih pelayanan yang akan dilakukan.',
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
            $customer = new Customer();
            $customer->name = $request->input('name');
            $customer->email = $request->input('email');
            $customer->save();

            // Ambil nomor antrean terakhir
            $lastQueue = Registration::whereDate('created_at', now()->toDateString())
                ->orderByDesc('id')
                ->value('queue_number');

            $number = $lastQueue ? (int) $lastQueue + 1 : 1;
            $formatted = str_pad($number, 4, '0', STR_PAD_LEFT); // hasil misalnya "0001", "0002", dst.

            $register = new Registration();
            $register->customer_id = $customer->id;
            $register->service_id = $request->input('service_id');
            $register->queue_number = $formatted;
            $register->status = "PENDING";
            $register->save();

            DB::commit();
            return redirect()->route('register.get-data')
                            ->with('success', 'Registrasi berhasil.')
                            ->with('data', $register);
        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput() // biar data form tidak hilang
                            ->withErrors(['message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function callCustomer($id)
    {
        $data = Registration::findOrFail($id);

        $data->status = "CALLING";
        $data->called_at = now();
        $data->save();

        return redirect()->route('register.get-data')
                            ->with('success', 'Memanggil pelanggan berhasil.');
    }

    public function servingCustomer($id)
    {
        $data = Registration::findOrFail($id);

        $data->status = "SERVING";
        $data->save();

        return redirect()->route('register.get-data')
                            ->with('success', 'Pelanggan sedang dilayani.');
    }

    public function completeCustomer($id)
    {
        $data = Registration::findOrFail($id);

        $data->status = "COMPLETED";
        $data->save();

        return redirect()->route('register.get-data')
                            ->with('success', 'Pelanggan sedang dilayani.');
    }
}
