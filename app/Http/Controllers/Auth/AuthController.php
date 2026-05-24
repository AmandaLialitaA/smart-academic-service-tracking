<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // ── Tampilkan halaman pilih role ──────────────────────────
    public function showSelectRole()
    {
        return view('auth.login-select');
    }

    // ── Tampilkan form login per role ─────────────────────────
    public function showLoginMahasiswa()
    {
        return view('auth.login-mahasiswa');
    }

    public function showLoginDosen()
    {
        return view('auth.login-dosen');
    }

    public function showLoginAdmin()
    {
        return view('auth.login-admin');
    }

    // ── Proses login (satu method untuk semua role) ───────────
    public function login(Request $request, string $role)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Coba autentikasi
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $user = Auth::user();

        // Pastikan role sesuai halaman login yang diakses
        if ($user->role !== $role) {
            Auth::logout();
            $request->session()->invalidate();
            throw ValidationException::withMessages([
                'email' => "Akun ini terdaftar sebagai {$user->role}, bukan {$role}.",
            ]);
        }

        $request->session()->regenerate();

        // Redirect ke dashboard sesuai role
        return match($user->role) {
            'mahasiswa' => redirect()->intended('/dashboard'),
            'dosen'     => redirect()->intended('/dosen/dashboard'),
            'admin'     => redirect()->intended('/admin/dashboard'),
        };
    }

    // ── Logout ────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}