<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model {
    protected $table = 'izin';

    const MAX_HARI_IZIN = 1;
    const MAX_HARI_SAKIT = 3;

    protected $fillable = [
        'karyawan_id', 'jenis_izin', 'tanggal',
        'keterangan', 'surat_keterangan', 'status'
    ];

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function cekBatasHari(string $jenis): bool {
        $max = $jenis === 'sakit' ? self::MAX_HARI_SAKIT : self::MAX_HARI_IZIN;
        $total = self::where('karyawan_id', $this->karyawan_id)
        ->where('jenis_izin', $jenis)
        ->whereMonth('tanggal', now()->month)
        ->count();
        return $total < $max;
    }
}