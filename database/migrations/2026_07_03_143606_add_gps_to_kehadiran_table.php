<?php

// database/migrations/xxxx_xx_xx_add_gps_to_kehadirans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kehadirans', function (Blueprint $table) {
            $table->decimal('latitude_masuk', 10, 7)->nullable()->after('jam_masuk');
            $table->decimal('longitude_masuk', 10, 7)->nullable()->after('latitude_masuk');
            $table->decimal('latitude_keluar', 10, 7)->nullable()->after('jam_keluar');
            $table->decimal('longitude_keluar', 10, 7)->nullable()->after('latitude_keluar');
        });
    }

    public function down()
    {
        Schema::table('kehadirans', function (Blueprint $table) {
            $table->dropColumn(['latitude_masuk', 'longitude_masuk', 'latitude_keluar', 'longitude_keluar']);
        });
    }
};