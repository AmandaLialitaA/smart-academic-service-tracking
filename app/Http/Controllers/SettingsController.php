<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('settings', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', 'min:8'],
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function adminUsersIndex()
    {
        $users = User::orderBy('role')->orderBy('name')->get();

        return view('admin.settings', compact('users'));
    }

    public function adminStoreUser(Request $request)
    {
        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'role'     => ['required', 'in:admin,mahasiswa,dosen'],
            'password' => ['required', 'min:8', 'confirmed'],
        ];

        if ($request->role === 'mahasiswa') {
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

        User::create($userData);

        return redirect()->route('admin.settings')->with('success', 'User berhasil dibuat.');
    }

    public function adminUpdateUser(Request $request, User $user)
    {
        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'role'  => ['required', 'in:admin,mahasiswa,dosen'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ];

        if ($request->role === 'mahasiswa') {
            $rules['nim'] = ['required', 'string', 'max:20', Rule::unique('users', 'nim')->ignore($user->id)];
            $rules['prodi'] = ['required', 'string', 'max:255'];
            $rules['semester'] = ['required', 'integer', 'min:1', 'max:14'];
        }

        $data = $request->validate($rules);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];

        if ($data['role'] === 'mahasiswa') {
            $user->nim = $data['nim'];
            $user->prodi = $data['prodi'];
            $user->semester = $data['semester'];
        } else {
            $user->nim = null;
            $user->prodi = null;
            $user->semester = null;
        }

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('admin.settings')->with('success', 'User berhasil diperbarui.');
    }

    public function adminDestroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.settings')->with('success', 'User berhasil dihapus.');
    }
}
