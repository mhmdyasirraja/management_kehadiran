<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izin', function (Blueprint $table) {
            $table->index(['karyawan_id', 'status', 'tanggal_mulai', 'tanggal_selesai'], 'idx_izin_overlap_check');
        });
    }

    public function down(): void
    {
        Schema::table('izin', function (Blueprint $table) {
            $table->dropIndex('idx_izin_overlap_check');
        });
    }
};
