<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showSelectRole()
    {
        return view('auth.login');
    }

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

    public function showRegister(Request $request)
    {
        $role = $request->query('role', 'mahasiswa');
        if (!in_array($role, ['mahasiswa', 'dosen'])) {
            $role = 'mahasiswa';
        }

        return view('auth.register', compact('role'));
    }

    public function register(Request $request)
    {
        $role = $request->input('role', 'mahasiswa');

        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
            'role'     => ['required', 'in:mahasiswa,dosen'],
        ];

        if ($role === 'mahasiswa') {
            $rules['nim'] = ['required', 'string', 'max:20', 'unique:users,nim'];
            $rules['prodi'] = ['required', 'string', 'max:255'];
            $rules['semester'] = ['required', 'integer', 'min:1', 'max:14'];
        }

        $data = $request->validate($rules);

        $userData = [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ];

        if ($data['role'] === 'mahasiswa') {
            $userData['nim'] = $data['nim'];
            $userData['prodi'] = $data['prodi'];
            $userData['semester'] = $data['semester'];
        }

        $user = User::create($userData);

        Auth::login($user);
        $request->session()->regenerate();

        return match ($user->role) {
            'mahasiswa' => redirect()->route('mahasiswa.dashboard')->with('success', 'Akun berhasil dibuat!'),
            'dosen'     => redirect()->route('dosen.dashboard')->with('success', 'Akun berhasil dibuat!'),
            default     => redirect('/login'),
        };
    }

    public function loginMahasiswa(Request $request)
    {
        return $this->processLogin($request, 'mahasiswa');
    }

    public function loginDosen(Request $request)
    {
        return $this->processLogin($request, 'dosen');
    }

    public function loginAdmin(Request $request)
    {
        return $this->processLogin($request, 'admin');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout.');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => __($status),
        ]);
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login.');
        }

        throw ValidationException::withMessages([
            'email' => __($status),
        ]);
    }

    private function processLogin(Request $request, string $role)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
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
            'mahasiswa' => redirect()->intended(route('mahasiswa.dashboard')),
            'dosen'     => redirect()->intended(route('dosen.dashboard')),
            'admin'     => redirect()->intended(route('admin.dashboard')),
            default     => redirect('/login'),
        };
    }
}
