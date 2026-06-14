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

            {{-- INFO USER --}}
            <div style="padding:22px; border:1px solid #DDD; background:#F9F9F9;">
                <strong>Nama:</strong> {{ auth()->user()->name }}<br>
                <strong>Email:</strong> {{ auth()->user()->email }}<br>
                <strong>Peran:</strong> {{ ucfirst(auth()->user()->role ?? 'Pengguna') }}
            </div>


            {{-- FOTO PROFIL --}}
            <div style="padding:28px; border:1px solid #EEE; background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,0.04);">
                <h2 style="font-size:18px; margin-bottom:18px; font-family:'Barlow Condensed',sans-serif; letter-spacing:.5px;">Foto Profil</h2>

                <form method="POST" action="{{ route('settings.avatar.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div style="display:flex; align-items:center; gap:28px; flex-wrap:wrap;">

                        <div style="position:relative; width:120px; height:120px; flex-shrink:0;">
                            <div style="
                                width:120px; height:120px; border-radius:50%;
                                background:linear-gradient(135deg,#a259e6,#7c3aed);
                                padding:3px; box-shadow:0 4px 14px rgba(124,58,237,0.25);">
                                <img id="avatarPreview"
                                    src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                                    alt="Avatar"
                                    style="width:100%; height:100%; object-fit:cover; border-radius:50%; border:3px solid #fff; display:block;">
                            </div>

                            <label for="avatarInput" style="
                                position:absolute; bottom:-4px; right:-4px;
                                width:36px; height:36px;
                                background:#7c3aed; color:#fff;
                                border-radius:50%;
                                display:flex; align-items:center; justify-content:center;
                                cursor:pointer; font-size:16px; border:3px solid #fff;
                                box-shadow:0 2px 6px rgba(0,0,0,0.15);
                                transition: background .15s ease;"
                                onmouseover="this.style.background='#6d28d9'"
                                onmouseout="this.style.background='#7c3aed'">
                                <i data-lucide="camera" style="width:16px; height:16px;"></i>
                            </label>

                            <input type="file" id="avatarInput" name="avatar" accept="image/*" required style="display:none;">
                        </div>

                        <div style="flex:1; min-width:200px;">
                            <p style="margin:0 0 4px; font-size:14px; font-weight:600; color:#222;">Ubah foto profil kamu</p>
                            <p style="margin:0 0 14px; font-size:13px; color:#888;">Format JPG atau PNG, maksimal 2MB. Foto akan terlihat di seluruh sistem.</p>
                            <button type="submit" id="avatarSaveBtn" class="prim-btn-primary"
                                    style="padding:10px 18px; border-radius:8px; display:none; font-weight:600;">
                                Simpan Foto
                            </button>
                            <span id="avatarFileName" style="display:none; font-size:13px; color:#666; margin-left:10px;"></span>
                        </div>
                    </div>
                </form>
            </div>

            {{-- GANTI PASSWORD --}}
            <div style="padding:28px; border:1px solid #EEE; background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,0.04);">
                <h2 style="font-size:18px; margin-bottom:18px; font-family:'Barlow Condensed',sans-serif; letter-spacing:.5px;">Ganti Password</h2>
                <form method="POST" action="{{ route('settings.password.update') }}">
                    @csrf
                    <div style="display:grid; gap:14px; max-width:420px;">
                        <label style="font-size:14px; font-weight:600; color:#333;">
                            Current Password
                            <input type="password" name="current_password" required
                                style="width:100%; padding:10px 12px; margin-top:6px; border:1px solid #DDD; border-radius:8px; font-size:14px;" />
                        </label>
                        <label style="font-size:14px; font-weight:600; color:#333;">
                            New Password
                            <input type="password" name="password" required
                                style="width:100%; padding:10px 12px; margin-top:6px; border:1px solid #DDD; border-radius:8px; font-size:14px;" />
                        </label>
                        <label style="font-size:14px; font-weight:600; color:#333;">
                            Confirm New Password
                            <input type="password" name="password_confirmation" required
                                style="width:100%; padding:10px 12px; margin-top:6px; border:1px solid #DDD; border-radius:8px; font-size:14px;" />
                        </label>
                        <div style="display:flex; gap:10px; margin-top:8px;">
                            <button type="submit" class="prim-btn-primary" style="padding:10px 18px; border-radius:8px; font-weight:600;">Simpan Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('avatarInput');
    const preview = document.getElementById('avatarPreview');
    const btn = document.getElementById('avatarSaveBtn');
    const fileName = document.getElementById('avatarFileName');

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            btn.style.display = 'inline-block';
            fileName.style.display = 'inline';
            fileName.textContent = file.name;
        } else {
            btn.style.display = 'none';
            fileName.style.display = 'none';
        }
    });

    if (window.lucide) lucide.createIcons();
});
</script>
@endsection