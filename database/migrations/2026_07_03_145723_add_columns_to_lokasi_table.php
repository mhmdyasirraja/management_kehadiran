<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lokasi', function (Blueprint $table) {
            $table->string('nama_lokasi')->after('id');
            $table->decimal('latitude', 10, 7)->after('nama_lokasi');
            $table->decimal('longitude', 10, 7)->after('latitude');
            $table->unsignedInteger('radius')->default(100)->after('longitude');
        });
    }

    public function down()
    {
        Schema::table('lokasi', function (Blueprint $table) {
            $table->dropColumn(['nama_lokasi', 'latitude', 'longitude', 'radius']);
        });
    }
};