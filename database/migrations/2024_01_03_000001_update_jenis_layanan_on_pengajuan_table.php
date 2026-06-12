<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pengajuan') || !Schema::hasColumn('pengajuan', 'jenis_layanan')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE pengajuan MODIFY COLUMN jenis_layanan VARCHAR(50) NOT NULL DEFAULT 'cuti'");
            return;
        }

        // SQLite: hapus kolom enum/check lalu buat ulang sebagai string
        $backup = DB::table('pengajuan')->pluck('jenis_layanan', 'id')->toArray();

        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn('jenis_layanan');
        });

        Schema::table('pengajuan', function (Blueprint $table) {
            $table->string('jenis_layanan', 50)->default('cuti');
        });

        foreach ($backup as $id => $jenis) {
            DB::table('pengajuan')->where('id', $id)->update(['jenis_layanan' => $jenis ?? 'cuti']);
        }
    }

    public function down(): void
    {
        //
    }
};
