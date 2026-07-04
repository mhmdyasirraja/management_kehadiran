<?php
// app/Console/Commands/GenerateStatusHarian.php

namespace App\Console\Commands;

use App\Models\Karyawan;
use App\Models\Kehadiran;
use App\Models\Izin;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateStatusHarian extends Command
{
    protected $signature = 'absensi:generate-status {tanggal?}';
    protected $description = 'Sinkronisasi status kehadiran harian: hadir/cuti/sakit sudah ada, sisanya alpha';

    public function handle()
    {
        // Default: proses tanggal kemarin (dijalankan tiap pagi untuk hari sebelumnya)
        $tanggal = $this->argument('tanggal')
            ? Carbon::parse($this->argument('tanggal'))->toDateString()
            : Carbon::yesterday()->toDateString();

        $semuaKaryawan = Karyawan::where('status', 'aktif')->get();

        $sudahAda = Kehadiran::whereDate('tanggal', $tanggal)
            ->pluck('karyawan_id')
            ->toArray();

        $izinApproved = Izin::where('status', 'approved')
            ->whereDate('tanggal_mulai', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->get()
            ->keyBy('karyawan_id');

        $jumlahAlpha = 0;
        $jumlahIzin = 0;

        foreach ($semuaKaryawan as $karyawan) {
            // Skip kalau sudah ada record untuk tanggal ini (misal sudah check-in)
            if (in_array($karyawan->id, $sudahAda)) {
                continue;
            }

            // Cek apakah karyawan ini sedang cuti/sakit approved di tanggal ini
            if (isset($izinApproved[$karyawan->id])) {
                $izin = $izinApproved[$karyawan->id];

                Kehadiran::create([
                    'karyawan_id' => $karyawan->id,
                    'tanggal'     => $tanggal,
                    'status'      => $izin->jenis_izin, // 'cuti' atau 'sakit'
                    'keterangan'  => $izin->keterangan,
                ]);

                $jumlahIzin++;
                continue;
            }

            // Tidak hadir, tidak izin/cuti/sakit → Alpha
            Kehadiran::create([
                'karyawan_id' => $karyawan->id,
                'tanggal'     => $tanggal,
                'status'      => 'alpha',
            ]);

            $jumlahAlpha++;
        }

        $this->info("Selesai untuk tanggal {$tanggal}: {$jumlahIzin} cuti/sakit, {$jumlahAlpha} alpha ditandai.");
    }
}