<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model {
    protected $table = 'kehadiran';

    protected $fillable = [
        'karyawan_id', 'tanggal', 'jam_check_in',
        'jam_check_out', 'lokasi_check_in',
        'lokasi_check_out', 'status'
    ];

    public function karyawan() {
        return $this->belongTo(Karyawan::class, 'karyawan_id');
    }

    public function getRekapKehadiran() {
        return self::with('karyawan')
        ->whereMonth('tanggal', now()->month)
        ->get();
    }

    public function hitungKehadiran(int $karyawanId) {
        return self::where('karyawan_id', $karyawanId)
        ->whereMonth('tanggal', now()->month)
        ->where('status', 'hadir')
        ->count();
    }
}