<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izin', function (Blueprint $table) {
            // 1. Paksa tipe data kolom 'karyawan_id' agar sama-sama string(6) seperti id karyawan
            $table->string('karyawan_id', 6)->change();
            
            // 2. Baru pasang relasi foreign key-nya
            $table->foreign('karyawan_id')
                ->references('id')
                ->on('karyawan')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('izin', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
        });
    }
};