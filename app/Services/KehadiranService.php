<?php
// app/Services/KehadiranService.php

namespace App\Services;

use App\Contracts\IKehadiran;
use App\Models\Kehadiran;
use App\Models\Lokasi;
use App\Models\Pengaturan;
use Carbon\Carbon;

class KehadiranService implements IKehadiran
{
    private function tanggalEfektif(): string
    {
        $cutoff = Carbon::today()->setTime(4, 0, 0);
        return Carbon::now()->lt($cutoff)
            ? Carbon::yesterday()->toDateString()
            : Carbon::today()->toDateString();
    }

    private function dalamRentangWaktu(string $jamMulai, string $jamSelesai): bool
    {
        $sekarang = Carbon::now();
        $batasMulai = Carbon::today()->setTimeFromTimeString($jamMulai);
        $batasSelesai = Carbon::today()->setTimeFromTimeString($jamSelesai);

        return $sekarang->between($batasMulai, $batasSelesai);
    }

    public function checkIn($karyawan, float $latitude, float $longitude): array
    {
        $checkinMulai = Pengaturan::get('checkin_mulai', '06:00');
        $checkinSelesai = Pengaturan::get('checkin_selesai', '09:00');

        if (!$this->dalamRentangWaktu($checkinMulai, $checkinSelesai)) {
            $sekarang = Carbon::now();
            $batasMulai = Carbon::today()->setTimeFromTimeString($checkinMulai);

            if ($sekarang->lt($batasMulai)) {
                return [
                    'success' => false,
                    'message' => 'Belum waktunya check-in. Check-in dibuka mulai pukul ' . Carbon::parse($checkinMulai)->format('H:i'),
                ];
            }

            return [
                'success' => false,
                'message' => 'Waktu check-in sudah berakhir. Check-in ditutup pukul ' . Carbon::parse($checkinSelesai)->format('H:i'),
            ];
        }

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

        $jamMasuk = Carbon::now(); // ← catat jam sungguhan, bukan standar 07:00 lagi

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
            'message' => 'Check-in berhasil pukul ' . $jamMasuk->format('H:i') . ' di ' . $lokasi->nama_lokasi,
        ];
    }

    public function checkOut($karyawan, float $latitude, float $longitude): array
    {
        $checkoutMulai = Pengaturan::get('checkout_mulai', '16:00');
        $checkoutSelesai = Pengaturan::get('checkout_selesai', '19:00');

        if (!$this->dalamRentangWaktu($checkoutMulai, $checkoutSelesai)) {
            $sekarang = Carbon::now();
            $batasMulai = Carbon::today()->setTimeFromTimeString($checkoutMulai);

            if ($sekarang->lt($batasMulai)) {
                return [
                    'success' => false,
                    'message' => 'Belum waktunya check-out. Check-out dibuka mulai pukul ' . Carbon::parse($checkoutMulai)->format('H:i'),
                ];
            }

            return [
                'success' => false,
                'message' => 'Waktu check-out sudah berakhir. Check-out ditutup pukul ' . Carbon::parse($checkoutSelesai)->format('H:i'),
            ];
        }

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

        $jamKeluar = Carbon::now(); // ← catat jam sungguhan, bukan standar 17:00 lagi

        $kehadiran->update([
            'jam_keluar'       => $jamKeluar->toTimeString(),
            'latitude_keluar'  => $latitude,
            'longitude_keluar' => $longitude,
        ]);

        return [
            'success' => true,
            'message' => 'Check-out berhasil pukul ' . $jamKeluar->format('H:i') . ' di ' . $lokasi->nama_lokasi,
        ];
    }

    public function riwayat($karyawan)
    {
        return Kehadiran::where('karyawan_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->get();
    }
}