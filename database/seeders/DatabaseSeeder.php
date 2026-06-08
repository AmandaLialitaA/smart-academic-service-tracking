<?php

namespace Database\Seeders;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ─────────────────────────────────────────────

        $admin = User::create([
            'name'     => 'Admin TU',
            'email'    => 'admin@tu.ac.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        $dosen = User::create([
            'name'     => 'Dr. Ahmad Fauzi, M.Kom',
            'email'    => 'dosen@ac.id',
            'password' => Hash::make('dosen123'),
            'role'     => 'dosen',
            'nim'      => 'NIP198501012010011001',
        ]);

        $mahasiswa = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'mahasiswa@ac.id',
            'password' => Hash::make('mahasiswa123'),
            'role'     => 'mahasiswa',
            'nim'      => '2021010001',
            'prodi'    => 'Teknik Informatika',
            'semester' => 6,
        ]);

        $mahasiswa2 = User::create([
            'name'     => 'Sari Dewi',
            'email'    => 'mahasiswa2@ac.id',
            'password' => Hash::make('mahasiswa123'),
            'role'     => 'mahasiswa',
            'nim'      => '2021010002',
            'prodi'    => 'Sistem Informasi',
            'semester' => 4,
        ]);

        // ── Pengajuan dummy ───────────────────────────────────

        // Pengajuan 1: sudah sampai tahap dosen_ttd
        Pengajuan::create([
            'kode'                => 'REQ-2024-00001',
            'mahasiswa_id'        => $mahasiswa->id,
            'dosen_id'            => $dosen->id,
            'admin_verifikasi_id' => $admin->id,
            'jenis_layanan'       => 'aktif-kuliah',
            'nama_mahasiswa'      => $mahasiswa->name,
            'nim_mahasiswa'       => $mahasiswa->nim,
            'prodi_mahasiswa'     => $mahasiswa->prodi,
            'semester_mahasiswa'  => $mahasiswa->semester,
            'keperluan'           => 'Keperluan beasiswa Bidikmisi semester genap 2024.',
            'status'              => 'dosen_ttd',
            'tanggal_submit'      => now()->subDays(3),
            'tanggal_verifikasi'  => now()->subDays(2),
        ]);

        // Pengajuan 2: baru submitted
        Pengajuan::create([
            'kode'               => 'REQ-2024-00002',
            'mahasiswa_id'       => $mahasiswa2->id,
            'jenis_layanan'      => 'transkrip',
            'nama_mahasiswa'     => $mahasiswa2->name,
            'nim_mahasiswa'      => $mahasiswa2->nim,
            'prodi_mahasiswa'    => $mahasiswa2->prodi,
            'semester_mahasiswa' => $mahasiswa2->semester,
            'keperluan'          => 'Keperluan pendaftaran magang di PT ABC.',
            'status'             => 'submitted',
            'tanggal_submit'     => now()->subHours(2),
        ]);

        // Pengajuan 3: selesai
        Pengajuan::create([
            'kode'                => 'REQ-2024-00003',
            'mahasiswa_id'        => $mahasiswa->id,
            'dosen_id'            => $dosen->id,
            'admin_verifikasi_id' => $admin->id,
            'admin_selesai_id'    => $admin->id,
            'jenis_layanan'       => 'legalisir',
            'nama_mahasiswa'      => $mahasiswa->name,
            'nim_mahasiswa'       => $mahasiswa->nim,
            'prodi_mahasiswa'     => $mahasiswa->prodi,
            'semester_mahasiswa'  => $mahasiswa->semester,
            'keperluan'           => 'Legalisir ijazah untuk melamar kerja.',
            'status'              => 'selesai',
            'tanggal_submit'      => now()->subDays(10),
            'tanggal_verifikasi'  => now()->subDays(9),
            'tanggal_ttd'         => now()->subDays(8),
            'tanggal_selesai'     => now()->subDays(7),
        ]);

        $this->command->info('');
        $this->command->info('✓ Database berhasil di-seed!');
        $this->command->info('');
        $this->command->info('╔══════════════════════════════════════════╗');
        $this->command->info('║           AKUN LOGIN TERSEDIA            ║');
        $this->command->info('╠══════════════════════════════════════════╣');
        $this->command->info('║ ADMIN                                    ║');
        $this->command->info('║   Email    : admin@tu.ac.id              ║');
        $this->command->info('║   Password : admin123                    ║');
        $this->command->info('╠══════════════════════════════════════════╣');
        $this->command->info('║ DOSEN                                    ║');
        $this->command->info('║   Email    : dosen@ac.id                 ║');
        $this->command->info('║   Password : dosen123                    ║');
        $this->command->info('╠══════════════════════════════════════════╣');
        $this->command->info('║ MAHASISWA 1                              ║');
        $this->command->info('║   Email    : mahasiswa@ac.id             ║');
        $this->command->info('║   Password : mahasiswa123                ║');
        $this->command->info('╠══════════════════════════════════════════╣');
        $this->command->info('║ MAHASISWA 2                              ║');
        $this->command->info('║   Email    : mahasiswa2@ac.id            ║');
        $this->command->info('║   Password : mahasiswa123                ║');
        $this->command->info('╚══════════════════════════════════════════╝');
    }
}