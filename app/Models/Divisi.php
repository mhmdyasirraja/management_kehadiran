<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    // FIX: Beritahu Laravel kalau nama tabel di database adalah 'divisi'
    protected $table = 'divisi';

    protected $fillable = ['nama']; 

    /**
     * Relasi ke tabel Karyawan
     */
    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'divisi_id', 'id');
    }
}