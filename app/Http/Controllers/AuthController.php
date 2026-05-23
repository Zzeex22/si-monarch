<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Nampilin halaman form login
    public function index()
    {
        return view('auth.login');
    }

    // Proses pencocokan data login
    public function login(Request $request)
    {
        // Validasi inputan form
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Coba login pakai Auth Laravel
        if (Auth::attempt($credentials)) {
            // Kalau berhasil, generate session baru biar aman
            $request->session()->regenerate();

            // Cek role-nya apa, lalu lempar ke dashboard masing-masing
            $role = Auth::user()->role;
            if ($role === 'Direktur') {
                return redirect()->intended('/direktur/dashboard');
            } elseif ($role === 'Komisaris') {
                return redirect()->intended('/komisaris/dashboard');
            }

            // Default fallback kalau role-nya gak jelas
            return redirect()->intended('/');
        }

        // Kalau gagal, balik lagi ke halaman login bawa pesan error
        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->onlyInput('username');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}