@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('head')
    @vite(['resources/css/dashboard-admin.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-admin')
@endsection
@section('content')
<div class="da-wrap" style="padding:24px;">
    <h1 class="da-title">KELOLA PENGGUNA</h1>
    <p class="da-subtitle">Buat, edit, atau hapus akun mahasiswa, dosen, dan admin.</p>

    @if($errors->any())
        <div style="background:#fff6f6;border:2px solid #E53935;padding:12px 16px;margin:12px 0;color:#a00;border-radius:6px;">
            <strong>Terdapat kesalahan:</strong>
            <ul style="margin:6px 0 0 18px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- POINT 2: Form buat user baru --}}
    <div style="border:2px solid #a259e6;padding:20px;border-radius:8px;margin-bottom:24px;background:#faf5ff;">
        <h3 style="margin-bottom:14px;">➕ Buat Akun Baru</h3>
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Nama Lengkap <span style="color:#E53935;">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                           placeholder="Nama lengkap">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Email <span style="color:#E53935;">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                           placeholder="email@ums.ac.id">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Password <span style="color:#E53935;">*</span></label>
                    <input type="password" name="password" required minlength="8"
                           style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                           placeholder="Min. 8 karakter">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Role <span style="color:#E53935;">*</span></label>
                    <select name="role" required id="role-select"
                            style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;">
                        <option value="mahasiswa" {{ old('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ old('role') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>

            {{-- Field tambahan untuk mahasiswa --}}
            <div id="mahasiswa-fields" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim') }}"
                           style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                           placeholder="NIM mahasiswa">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Program Studi</label>
                    <input type="text" name="prodi" value="{{ old('prodi') }}"
                           style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                           placeholder="Contoh: Informatika">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Semester</label>
                    <input type="number" name="semester" value="{{ old('semester') }}" min="1" max="14"
                           style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                           placeholder="1-14">
                </div>
            </div>

            <button type="submit"
                    style="padding:10px 24px;background:#a259e6;color:#fff;border:none;cursor:pointer;border-radius:4px;font-weight:700;font-size:14px;">
                ✅ Buat Akun
            </button>
        </form>
    </div>

    {{-- Daftar user --}}
    <div style="border:2px solid #111;border-radius:8px;overflow:hidden;">
        <div style="padding:14px 16px;background:#f5f5f5;border-bottom:2px solid #111;">
            <h3 style="margin:0;">Daftar Pengguna</h3>
        </div>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="text-align:left;border-bottom:2px solid #eee;background:#fafafa;">
                    <th style="padding:10px 12px;font-size:12px;">NAMA</th>
                    <th style="padding:10px 12px;font-size:12px;">EMAIL</th>
                    <th style="padding:10px 12px;font-size:12px;">ROLE</th>
                    <th style="padding:10px 12px;font-size:12px;">NIM/INFO</th>
                    <th style="padding:10px 12px;font-size:12px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr style="border-bottom:1px solid #f0f0f0;">
                    <td style="padding:10px 12px;font-size:13px;">
                        <strong>{{ $u->name }}</strong>
                        @if($u->id === auth()->id())
                            <span style="font-size:11px;color:#a259e6;font-weight:600;"> (Anda)</span>
                        @endif
                    </td>
                    <td style="padding:10px 12px;font-size:13px;">{{ $u->email }}</td>
                    <td style="padding:10px 12px;">
                        <span style="padding:3px 8px;border-radius:12px;font-size:11px;font-weight:700;
                            background:{{ $u->role === 'admin' ? '#fef3c7' : ($u->role === 'dosen' ? '#e0f2fe' : '#f3e8ff') }};
                            color:{{ $u->role === 'admin' ? '#92400e' : ($u->role === 'dosen' ? '#075985' : '#6b21a8') }};">
                            {{ strtoupper($u->role) }}
                        </span>
                    </td>
                    <td style="padding:10px 12px;font-size:12px;color:#888;">
                        @if($u->nim) NIM: {{ $u->nim }} @endif
                        @if($u->prodi) · {{ $u->prodi }} @endif
                        @if($u->semester) · Sem {{ $u->semester }} @endif
                    </td>
                    <td style="padding:10px 12px;">
                        <div style="display:flex;gap:6px;align-items:center;">
                            {{-- POINT 3: hapus akun dari DB --}}
                            @if($u->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                  onsubmit="return confirm('Hapus akun {{ addslashes($u->name) }} dari database? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="padding:5px 10px;background:#E53935;color:#fff;border:none;cursor:pointer;border-radius:4px;font-size:12px;">
                                    🗑 Hapus
                                </button>
                            </form>
                            @else
                            <span style="font-size:12px;color:#999;">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding:20px;text-align:center;color:#888;">Belum ada pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="padding:12px 16px;">
            {{ $users->links() }}
        </div>
    </div>
</div>

<script>
    // Toggle field mahasiswa berdasarkan role yang dipilih
    const roleSelect = document.getElementById('role-select');
    const mhsFields  = document.getElementById('mahasiswa-fields');

    function toggleMhsFields() {
        mhsFields.style.display = roleSelect.value === 'mahasiswa' ? 'grid' : 'none';
    }

    roleSelect.addEventListener('change', toggleMhsFields);
    toggleMhsFields(); // init
</script>
@endsection