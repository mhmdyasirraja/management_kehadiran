<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Izin;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';

    protected $fillable = [
        'user_id',
        'nama',
        'divisi_id',
        'status',
        'nip',
    ];

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'karyawan_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function izin()
    {
        return $this->hasMany(Izin::class, 'karyawan_id');
    }
}
