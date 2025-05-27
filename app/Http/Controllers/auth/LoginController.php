<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function formLogin()
    {
        // Redirect to homepage with login modal if accessed directly
        return redirect()->route('home-page')->with('show_login_modal', true);
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
            return redirect()->route('home-page')
                ->withErrors($validator)
                ->withInput()
                ->with('show_login_modal', true);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Berhasil login - redirect ke dashboard
            return redirect()->intended(route('dashboard'));
        }

        // Gagal login
        return redirect()->route('home-page')
            ->withErrors([
                'credentials' => 'Email atau Password anda salah.',
            ])
            ->with('show_login_modal', true);
    }

    public function dashboard()
    {
        // Pastikan user sudah login (middleware auth sudah handle ini)
        return view('auth.dashboard');
    }

    public function logout()
    {
        Auth::logout();

        // Invalidate the session
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home-page')->with('success', 'Anda telah berhasil logout.');
    }
}
