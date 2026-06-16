<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ────────────────────────────────────────────
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@ums.ac.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // ── Dosen ────────────────────────────────────────────
        User::create([
            'name'     => 'Dr. Ahmad Yani, S.T., M.T.',
            'email'    => 'ahmad.yani@ums.ac.id',
            'password' => Hash::make('dosen123'),
            'role'     => 'dosen',
        ]);

        User::create([
            'name'     => 'Dr. Siti Rahayu, M.Pd.',
            'email'    => 'siti.rahayu@ums.ac.id',
            'password' => Hash::make('dosen123'),
            'role'     => 'dosen',
        ]);

        // ── Mahasiswa ─────────────────────────────────────────
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@student.ums.ac.id',
            'password' => Hash::make('mahasiswa123'),
            'role'     => 'mahasiswa',
            'nim'      => 'L200210001',
            'prodi'    => 'Teknik Informatika',
            'semester' => 6,
        ]);

        User::create([
            'name'     => 'Sari Dewi',
            'email'    => 'sari@student.ums.ac.id',
            'password' => Hash::make('mahasiswa123'),
            'role'     => 'mahasiswa',
            'nim'      => 'L200210002',
            'prodi'    => 'Teknik Informatika',
            'semester' => 4,
        ]);

        $this->command->info('✓ Seeder selesai. Akun tersedia:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',     'admin@ums.ac.id',        'admin123'],
                ['Dosen',     'ahmad.yani@ums.ac.id',   'dosen123'],
                ['Dosen',     'siti.rahayu@ums.ac.id',  'dosen123'],
                ['Mahasiswa', 'budi@student.ums.ac.id', 'mahasiswa123'],
                ['Mahasiswa', 'sari@student.ums.ac.id', 'mahasiswa123'],
            ]
        );
    }
}