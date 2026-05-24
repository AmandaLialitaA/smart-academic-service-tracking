<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // REQ-2024-XXXXX

            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dosen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('admin_verifikasi_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('admin_selesai_id')->nullable()->constrained('users')->nullOnDelete();

            $table->enum('jenis_layanan', [
                'aktif-kuliah',
                'transkrip',
                'cuti',
                'legalisir',
            ]);

            // Snapshot data mahasiswa saat pengajuan
            $table->string('nama_mahasiswa');
            $table->string('nim_mahasiswa');
            $table->string('prodi_mahasiswa');
            $table->integer('semester_mahasiswa');
            $table->text('keperluan');

            // Workflow status
            $table->enum('status', [
                'submitted',        // 1. Mahasiswa submit
                'admin_verifikasi', // 2. Admin sedang verifikasi
                'dosen_ttd',        // 3. Dosen TTD
                'selesai',          // 4. Siap ambil
                'ditolak',          // Bisa dari tahap manapun
            ])->default('submitted');

            // Timestamps tiap tahap
            $table->timestamp('tanggal_submit')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->timestamp('tanggal_ttd')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamp('tanggal_ditolak')->nullable();

            // Catatan tiap aktor
            $table->text('catatan_admin')->nullable();
            $table->text('catatan_dosen')->nullable();
            $table->text('catatan_penolakan')->nullable();

            $table->timestamps();
        });

        Schema::create('dokumen_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan')->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->enum('tipe_dokumen', ['ktm', 'surat_permohonan', 'transkrip', 'lainnya']);
            $table->string('path_file');
            $table->string('nama_file_asli');
            $table->integer('ukuran_file'); // bytes
            $table->string('mime_type');
            $table->timestamps();
        });

        Schema::create('log_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status_dari')->nullable();
            $table->string('status_ke');
            $table->text('catatan')->nullable();
            $table->enum('actor_role', ['mahasiswa', 'admin', 'dosen', 'system']);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_pengajuan');
        Schema::dropIfExists('dokumen_pengajuan');
        Schema::dropIfExists('pengajuan');
    }
};