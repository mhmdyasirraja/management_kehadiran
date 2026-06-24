<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kehadiran', function (Blueprint $table) {
            // 1. Paksa tipe data kolom 'karyawan_id' agar kembar dengan id karyawan (string 6 digit)
            $table->string('karyawan_id', 6)->change();

            // 2. Pasang relasi foreign key ke tabel karyawan (tanpa S)
            $table->foreign('karyawan_id')
                ->references('id')
                ->on('karyawan')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('kehadiran', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
        });
    }
};