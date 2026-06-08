<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['mahasiswa', 'dosen', 'admin'])
                  ->default('mahasiswa')
                  ->after('email');

            $table->string('nim')->nullable()->unique()->after('role');
            $table->string('prodi')->nullable()->after('nim');
            $table->unsignedTinyInteger('semester')->nullable()->after('prodi');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nim', 'prodi', 'semester']);
        });
    }
};
