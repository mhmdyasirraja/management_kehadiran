<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $table = 'izin';

    const MAX_HARI_IZIN  = 1;
    const MAX_HARI_SAKIT = 3;

    protected $fillable = [
        'karyawan_id',
        'jenis_izin',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'keterangan',
        'surat_keterangan',
        'status',
        'catatan_admin',
    ];

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function cekBatasHari(int $karyawanId, string $jenis, int $jumlahHari): bool
    {
        $max       = $jenis === 'sakit' ? self::MAX_HARI_SAKIT : self::MAX_HARI_IZIN;
        $totalUsed = self::where('karyawan_id', $karyawanId)
            ->where('jenis_izin', $jenis)
            ->whereIn('status', ['pending', 'disetujui'])
            ->whereMonth('tanggal_mulai', now()->month)
            ->sum('jumlah_hari');

        return ($totalUsed + $jumlahHari) <= $max;
    }

    
    public static function hitungHari(string $mulai, string $selesai): int
    {
        return \Carbon\Carbon::parse($mulai)
            ->diffInDays(\Carbon\Carbon::parse($selesai)) + 1;
    }
}