<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $messages = [
            'email.required' => 'Email harus diisi.',
            'email.email'   => 'Data yang dimasukan bukan format email.',
            'password.required' => 'Password harus diisi.',
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('show_login_modal', true); // Tambahkan flag untuk menampilkan modal
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Berhasil login
            return redirect()->intended(route('dashboard'));
        }

        // Gagal login
        return back()
            ->withErrors([
                'Messages' => 'Email atau Password anda salah.',
            ])
            ->with('show_login_modal', true); // Tambahkan flag untuk menampilkan modal
    }

    public function dashboard()
    {
        return view('auth.dashboard');
    }

    public function homePage()
    {
        // Ambil semua data service dari database dan urutkan berdasarkan nama
        $services = Service::orderBy('name', 'asc')->get();

        // Render view home page dengan data services
        return view('homepage', compact('services'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home-page');
    }
}
