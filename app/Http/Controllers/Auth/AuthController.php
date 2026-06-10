<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // ── Halaman pilih role ────────────────────────────────────
    public function showSelectRole()   { return view('auth.login-select'); }
    public function showLoginMahasiswa() { return view('auth.login-mahasiswa'); }
    public function showLoginDosen()   { return view('auth.login-dosen'); }
    public function showLoginAdmin()   { return view('auth.login-admin'); }

    // ── Proses login per role ─────────────────────────────────
    public function loginMahasiswa(Request $request) { return $this->loginAs($request, 'mahasiswa'); }
    public function loginDosen(Request $request)     { return $this->loginAs($request, 'dosen'); }
    public function loginAdmin(Request $request)     { return $this->loginAs($request, 'admin'); }

    // ── Logout ────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Berhasil logout.');
    }

    // ── Private: logika login ─────────────────────────────────
    private function loginAs(Request $request, string $role)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            Auth::logout();
            $request->session()->invalidate();
            throw ValidationException::withMessages([
                'email' => "Akun ini terdaftar sebagai {$user->role}, bukan {$role}.",
            ]);
        }

        $request->session()->regenerate();

        return match ($user->role) {
            'mahasiswa' => redirect()->intended('/dashboard'),
            'dosen'     => redirect()->intended('/dosen/dashboard'),
            'admin'     => redirect()->intended('/admin/dashboard'),
        };
    }
}