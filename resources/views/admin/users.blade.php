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

    {{-- Form buat user baru --}}
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
                    <select name="role" required id="role-select-create"
                            style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;">
                        <option value="mahasiswa" {{ old('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ old('role') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>

            {{-- Field mahasiswa --}}
            <div id="mahasiswa-fields-create" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">
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

            {{-- Field dosen --}}
            <div id="dosen-fields-create" style="display:none;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">NIDN</label>
                    <input type="text" name="nidn" value="{{ old('nidn') }}"
                           style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                           placeholder="Nomor Induk Dosen Nasional">
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
                    <th style="padding:10px 12px;font-size:12px;">NIM / NIDN / INFO</th>
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
                    <td style="padding:10px 12px;font-size:12px;color:#555;">
                        @if($u->role === 'dosen')
                            @if($u->nidn)
                                <span style="background:#e0f2fe;color:#075985;padding:2px 7px;border-radius:10px;font-weight:600;">NIDN: {{ $u->nidn }}</span>
                            @else
                                <span style="color:#bbb;font-style:italic;">NIDN belum diisi</span>
                            @endif
                        @elseif($u->role === 'mahasiswa')
                            @if($u->nim) <span>NIM: {{ $u->nim }}</span> @endif
                            @if($u->prodi) · {{ $u->prodi }} @endif
                            @if($u->semester) · Sem {{ $u->semester }} @endif
                            @if(!$u->nim && !$u->prodi && !$u->semester)
                                <span style="color:#bbb;font-style:italic;">Belum ada info</span>
                            @endif
                        @else
                            <span style="color:#bbb;">—</span>
                        @endif
                    </td>
                    <td style="padding:10px 12px;">
                        <div style="display:flex;gap:6px;align-items:center;">
                            {{-- Tombol Edit --}}
                            <button type="button"
                                    onclick="bukaModalEdit({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}', '{{ $u->role }}', '{{ $u->nim }}', '{{ $u->nidn }}', '{{ addslashes($u->prodi ?? '') }}', '{{ $u->semester }}')"
                                    style="padding:5px 10px;background:#2563eb;color:#fff;border:none;cursor:pointer;border-radius:4px;font-size:12px;">
                                ✏️ Edit
                            </button>

                            {{-- Tombol Hapus --}}
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

{{-- ── Modal Edit User ─────────────────────────────────────────────────────── --}}
<div id="modal-edit" style="display:none;position:fixed;inset:0;z-index:999;background:rgba(0,0,0,.45);align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:10px;padding:28px;width:100%;max-width:560px;max-height:90vh;overflow-y:auto;box-shadow:0 8px 32px rgba(0,0,0,.2);">
        <h3 style="margin:0 0 18px;">✏️ Edit Pengguna: <span id="edit-nama-label"></span></h3>

        <form id="form-edit" method="POST">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Nama Lengkap <span style="color:#E53935;">*</span></label>
                    <input type="text" name="name" id="edit-name" required
                           style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Email <span style="color:#E53935;">*</span></label>
                    <input type="email" name="email" id="edit-email" required
                           style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Password Baru <span style="color:#888;font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" minlength="8"
                           style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                           placeholder="Min. 8 karakter">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Role <span style="color:#E53935;">*</span></label>
                    <select name="role" id="edit-role" required
                            style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;">
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen">Dosen</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            {{-- Field dosen: NIDN --}}
            <div id="dosen-fields-edit" style="display:none;margin-bottom:12px;">
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">NIDN</label>
                <input type="text" name="nidn" id="edit-nidn"
                       style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                       placeholder="Nomor Induk Dosen Nasional">
                <p style="font-size:11px;color:#888;margin:4px 0 0;">Nomor Induk Dosen Nasional (10 digit). Kosongkan jika belum ada.</p>
            </div>

            {{-- Field mahasiswa --}}
            <div id="mahasiswa-fields-edit" style="display:none;margin-bottom:12px;">
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                    <div>
                        <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">NIM</label>
                        <input type="text" name="nim" id="edit-nim"
                               style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                               placeholder="NIM mahasiswa">
                    </div>
                    <div>
                        <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Program Studi</label>
                        <input type="text" name="prodi" id="edit-prodi"
                               style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                               placeholder="Contoh: Informatika">
                    </div>
                    <div>
                        <label style="font-size:13px;font-weight:600;display:block;margin-bottom:3px;">Semester</label>
                        <input type="number" name="semester" id="edit-semester" min="1" max="14"
                               style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"
                               placeholder="1-14">
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px;">
                <button type="button" onclick="tutupModalEdit()"
                        style="padding:9px 20px;background:#f0f0f0;color:#333;border:1px solid #ccc;cursor:pointer;border-radius:4px;font-size:13px;">
                    Batal
                </button>
                <button type="submit"
                        style="padding:9px 20px;background:#a259e6;color:#fff;border:none;cursor:pointer;border-radius:4px;font-weight:700;font-size:13px;">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ── Toggle field create form ──────────────────────────────────────────────────
const roleSelectCreate  = document.getElementById('role-select-create');
const mhsFieldsCreate   = document.getElementById('mahasiswa-fields-create');
const dosenFieldsCreate = document.getElementById('dosen-fields-create');

function toggleFieldsCreate() {
    const role = roleSelectCreate.value;
    mhsFieldsCreate.style.display   = role === 'mahasiswa' ? 'grid' : 'none';
    dosenFieldsCreate.style.display  = role === 'dosen'     ? 'grid' : 'none';
}
roleSelectCreate.addEventListener('change', toggleFieldsCreate);
toggleFieldsCreate();

// ── Modal Edit ────────────────────────────────────────────────────────────────
const modal         = document.getElementById('modal-edit');
const formEdit      = document.getElementById('form-edit');
const editRole      = document.getElementById('edit-role');
const dosenEdit     = document.getElementById('dosen-fields-edit');
const mhsEdit       = document.getElementById('mahasiswa-fields-edit');

function toggleFieldsEdit() {
    const role = editRole.value;
    dosenEdit.style.display = role === 'dosen'     ? 'block' : 'none';
    mhsEdit.style.display   = role === 'mahasiswa' ? 'block' : 'none';
}

editRole.addEventListener('change', toggleFieldsEdit);

function bukaModalEdit(id, name, email, role, nim, nidn, prodi, semester) {
    document.getElementById('edit-nama-label').textContent = name;
    document.getElementById('edit-name').value    = name;
    document.getElementById('edit-email').value   = email;
    editRole.value                                 = role;
    document.getElementById('edit-nidn').value    = nidn || '';
    document.getElementById('edit-nim').value     = nim || '';
    document.getElementById('edit-prodi').value   = prodi || '';
    document.getElementById('edit-semester').value = semester || '';

    formEdit.action = '/admin/users/' + id;

    toggleFieldsEdit();
    modal.style.display = 'flex';
}

function tutupModalEdit() {
    modal.style.display = 'none';
}

// Tutup modal klik di luar
modal.addEventListener('click', function(e) {
    if (e.target === modal) tutupModalEdit();
});
</script>
@endsection