@extends('layouts.app')

@section('title', 'Settings')
@section('topbar_name', auth()->user()->name ?? 'Pengguna')
@section('topbar_role', ucfirst(auth()->user()->role ?? 'user'))

@section('sidebar')
    @php
        $role = auth()->user()->role ?? 'mahasiswa';
    @endphp

    @if($role === 'admin')
        @include('components.sidebar-admin')
    @elseif($role === 'dosen')
        @include('components.sidebar-dosen')
    @else
        @include('components.sidebar-mahasiswa')
    @endif
@endsection

@section('content')
<div class="page-content" style="max-width:900px; margin:0 auto; padding:48px 0;">
    <div class="card" style="background:#fff; border:2px solid #111; padding:36px;">
        <h1 style="font-family:'Barlow Condensed',sans-serif; font-size:34px; margin-bottom:16px;">Pengaturan Akun</h1>
        <p style="font-size:15px; color:#444; line-height:1.8; margin-bottom:28px;">Halaman ini akan menampilkan pengaturan profil dan preferensi Anda. Untuk sementara, fitur pengaturan akan dikembangkan lebih lanjut.</p>
        <div style="display:grid; gap:18px;">
            <div style="padding:22px; border:1px solid #DDD; background:#F9F9F9;">
                <strong>Nama:</strong> {{ auth()->user()->name }}<br>
                <strong>Email:</strong> {{ auth()->user()->email }}<br>
                <strong>Peran:</strong> {{ ucfirst(auth()->user()->role ?? 'Pengguna') }}
            </div>

            @if(session('success'))
                <div style="padding:14px; border:1px solid #c7ecc7; background:#f0fff0; color:#0a7a0a;">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div style="padding:14px; border:1px solid #ffd6d6; background:#fff6f6; color:#a00;">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="padding:22px; border:1px solid #DDD; background:#F9F9F9;">
                <h2 style="font-size:18px; margin-bottom:10px;">Ganti Password</h2>
                <form method="POST" action="{{ route('settings.password.update') }}">
                    @csrf
                    <div style="display:grid; gap:8px; max-width:420px;">
                        <label>Current Password
                            <input type="password" name="current_password" required style="width:100%; padding:8px; margin-top:6px;" />
                        </label>
                        <label>New Password
                            <input type="password" name="password" required style="width:100%; padding:8px; margin-top:6px;" />
                        </label>
                        <label>Confirm New Password
                            <input type="password" name="password_confirmation" required style="width:100%; padding:8px; margin-top:6px;" />
                        </label>
                        <div style="display:flex; gap:10px; margin-top:8px;">
                            <button type="submit" class="prim-btn-primary" style="padding:10px 14px;">Simpan Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection