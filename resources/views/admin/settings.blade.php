@extends('layouts.app')
@section('title', 'Admin Settings')
@section('sidebar')
    @include('components.sidebar-admin')
@endsection
@section('content')
<div style="max-width:1000px;margin:0 auto;padding:32px 16px;">
    <h1 style="font-size:32px;margin-bottom:8px;">Kelola User (CRUD)</h1>
    <p style="color:#555;margin-bottom:24px;">Buat, ubah, dan hapus akun mahasiswa, dosen, dan admin.</p>

    <div style="display:grid;grid-template-columns:1fr 380px;gap:20px;">
        <div style="border:2px solid #111;padding:16px;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid #eee;text-align:left;">
                        <th style="padding:8px;">Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr style="border-bottom:1px solid #f2f2f2;">
                        <td style="padding:8px;">{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->role }}</td>
                        <td style="text-align:right;">
                            @if($u->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" style="display:inline;" onsubmit="return confirm('Hapus user?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:#E53935;color:#fff;border:none;padding:4px 8px;cursor:pointer;">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="border:2px solid #111;padding:20px;background:#f9f9f9;">
            <h2 style="margin-bottom:12px;">Buat User Baru</h2>
            <form method="POST" action="{{ route('admin.users.store') }}" style="display:grid;gap:8px;">
                @csrf
                <input name="name" placeholder="Nama" required style="padding:8px;">
                <input name="email" type="email" placeholder="Email" required style="padding:8px;">
                <select name="role" id="role-select" required style="padding:8px;" onchange="toggleMhsFields()">
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                    <option value="admin">Admin</option>
                </select>
                <div id="mhs-fields">
                    <input name="nim" placeholder="NIM" style="padding:8px;width:100%;margin-bottom:8px;">
                    <input name="prodi" placeholder="Prodi" style="padding:8px;width:100%;margin-bottom:8px;">
                    <input name="semester" type="number" min="1" max="14" placeholder="Semester" style="padding:8px;width:100%;">
                </div>
                <input name="password" type="password" placeholder="Password" required style="padding:8px;">
                <input name="password_confirmation" type="password" placeholder="Konfirmasi Password" required style="padding:8px;">
                <button type="submit" style="padding:10px;background:#111;color:#fff;border:none;cursor:pointer;">Buat User</button>
            </form>
        </div>
    </div>
</div>
<script>
function toggleMhsFields() {
    const role = document.getElementById('role-select').value;
    document.getElementById('mhs-fields').style.display = role === 'mahasiswa' ? 'block' : 'none';
}
toggleMhsFields();
</script>
@endsection
