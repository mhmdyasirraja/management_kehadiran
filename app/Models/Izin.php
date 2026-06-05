<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $table = 'izin';

    protected $fillable = [
        'karyawan_id',
        'jenis_izin',
        'tanggal',
        'keterangan',
        'status',
    ];
}