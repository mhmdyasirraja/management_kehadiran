<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_check_in',
        'jam_check_out',
        'lokasi_check_in',
        'lokasi_check_out',
        'durasi_kerja',
        'status',
    ];

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }
}