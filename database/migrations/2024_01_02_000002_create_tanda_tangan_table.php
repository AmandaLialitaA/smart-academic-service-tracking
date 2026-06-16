<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanda_tangan', function (Blueprint $table) {
    $table->id();

    $table->foreignId('pengajuan_id')
          ->unique()
          ->constrained('pengajuan')
          ->cascadeOnDelete();

    $table->foreignId('dosen_id')
          ->constrained('users')
          ->restrictOnDelete();

    $table->string('path_file');
    $table->string('nama_file');
    $table->string('ip_address', 45)->nullable();
    $table->timestamp('ditandatangani_pada')->useCurrent();

    // ── Tambahkan ini ──
    $table->string('path_pdf_ttd')->nullable();
    $table->text('catatan')->nullable();
    $table->unsignedSmallInteger('ttd_page')->nullable();
    $table->float('ttd_x_pct', 6, 4)->nullable();
    $table->float('ttd_y_pct', 6, 4)->nullable();
    $table->float('ttd_w_pct', 6, 4)->nullable();
    $table->float('ttd_h_pct', 6, 4)->nullable();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('tanda_tangan');
    }
};
