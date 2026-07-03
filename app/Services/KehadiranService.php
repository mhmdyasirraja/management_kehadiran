<?php
// app/Services/KehadiranService.php

namespace App\Services;

use App\Contracts\IKehadiran;
use App\Models\Kehadiran;
use App\Models\Lokasi;
use Carbon\Carbon;

class KehadiranService implements IKehadiran
{
    /**
     * Tentukan tanggal efektif absensi (reset jam 04:00 pagi).
     */
    private function tanggalEfektif(): string
    {
        $cutoff = Carbon::today()->setTime(4, 0, 0);
        return Carbon::now()->lt($cutoff)
            ? Carbon::yesterday()->toDateString()
            : Carbon::today()->toDateString();
    }

    public function checkIn($karyawan, float $latitude, float $longitude): array
    {
        // 1. Validasi lokasi GPS lewat Lokasi Model
        $lokasi = Lokasi::cariLokasiValid($latitude, $longitude);

        if (!$lokasi) {
            return [
                'success' => false,
                'message' => 'Anda berada di luar radius lokasi kantor. Check-in ditolak.',
            ];
        }

        $effectiveDate = $this->tanggalEfektif();

        $sudahCheckIn = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $effectiveDate)
            ->exists();

        if ($sudahCheckIn) {
            return [
                'success' => false,
                'message' => 'Anda sudah melakukan check-in hari ini',
            ];
        }

        $jamMasuk = Carbon::parse($effectiveDate . ' 07:00:00');

        // 2. Simpan ke Kehadiran Model -> Database
        Kehadiran::create([
            'karyawan_id'      => $karyawan->id,
            'tanggal'          => $effectiveDate,
            'jam_masuk'        => $jamMasuk->toTimeString(),
            'latitude_masuk'   => $latitude,
            'longitude_masuk'  => $longitude,
            'status'           => 'hadir',
        ]);

        return [
            'success' => true,
            'message' => 'Check-in berhasil pukul ' . Carbon::now()->format('H:i') . ' di ' . $lokasi->nama_lokasi,
        ];
    }

    public function checkOut($karyawan, float $latitude, float $longitude): array
    {
        $lokasi = Lokasi::cariLokasiValid($latitude, $longitude);

        if (!$lokasi) {
            return [
                'success' => false,
                'message' => 'Anda berada di luar radius lokasi kantor. Check-out ditolak.',
            ];
        }

        $effectiveDate = $this->tanggalEfektif();

        $kehadiran = Kehadiran::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $effectiveDate)
            ->first();

        if (!$kehadiran) {
            return [
                'success' => false,
                'message' => 'Anda belum melakukan check-in hari ini',
            ];
        }

        if ($kehadiran->jam_keluar) {
            return [
                'success' => false,
                'message' => 'Anda sudah melakukan check-out hari ini',
            ];
        }

        $jamKeluarStd = Carbon::parse($effectiveDate . ' 17:00:00');

        $kehadiran->update([
            'jam_keluar'       => $jamKeluarStd->toTimeString(),
            'latitude_keluar'  => $latitude,
            'longitude_keluar' => $longitude,
        ]);

        return [
            'success' => true,
            'message' => 'Check-out berhasil pukul 17:00 di ' . $lokasi->nama_lokasi,
        ];
    }

    public function riwayat($karyawan)
    {
        return Kehadiran::where('karyawan_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->get();
    }
}