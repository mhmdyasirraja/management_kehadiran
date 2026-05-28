<?php
namespace App\Models;

use App\Abstract\BaseUser;
use App\Contracts\IAuth;
use App\Contracts\IKehadiran;
use App\Contracts\IIzin;
use Illuminate\Support\Facades\Auth;

class Karyawan extends BaseUser implements IAuth, IKehadiran, IIzin {
    protected $table = 'users';

    protected $fillable = [
        'nama', 'email', 'password', 'role', 'divisi_id', 'jabatan'
    ];

    public function divisi() {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    public function kehadiran() {
        return $this->hasMany(Kehadiran::class, 'karyawan_id');
    }

    public function izin() {
        return $this->hasMany(Izin::class, 'karyawan_id');
    }

    public function login(string $email, string $password) {
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' => 'karyawan'])) {
            return redirect('/karyawan/dashboard');
        }
        return back()->with('error', 'Login Karyawan gagal');
    }

    public function getDashboard() {
        return view('karyawan.dashboard', [
            'kehadiranBulanIni' => $this->kehadiran()
            ->whereMonth('tanggal', now()->month)->count(),
            'izinPending' => $this->izin()
            ->where('status', 'pending')->count(),
        ]);
    }

    public function cekHakAkses(string $menu): bool {
        $akses = [
            'check-in', 'check-out',
            'ajukan-izin', 'riwayat-kehadiran', 'dashboard'
        ];
        return in_array($menu, $akses);
    }

    public function checkin(string $lokasi) {
        if (!$this->validasiLokasi($lokasi)) {
            return 'Lokasi tidak valid untuk check-in';
        }
        return Kehadiran::create([
            'karyawan_id' => $this->id,
            'tanggal' => now()->toDateString(),
            'jam_check_in' => now()->toTimeString(),
            'lokasi_check_in' => $lokasi,
            'status' => 'hadir'
        ]);
    }

    public function checkOut(string $lokasi) {
        if (!$this->validasiLokasi($lokasi)) {
            return 'Lokasi tidak valid untuk check-out';
        }
        $kehadiran = Kehadiran::where('karyawan_id', $this->id)
        ->whereDate('tanggal', now()->toDateString())
        ->first();
        $kehadiran->update([
            'jam-check_out' => now()->toTimeString(),
            'lokasi_check_out' => $lokasi
        ]);
        return $kehadiran;
    }

    public function validasiLokasi(string $lokasi): bool {
        $lokasiValid = Lokasi::first();
        if (!$lokasiValid) return false;
        $jarak = $lokasiValid->hitungJarak(
            explode(',', $lokasi)[0],
            explode(',', $lokasi)[1],
            $lokasiValid->latitude,
            $lokasiValid->longitude
        );
        return $jarak <= $lokasiValid->radius;
    }

    public function getRekapKehadiran() {
        return $this->kehadiran()
        ->whereMonth('tanggal', now()->month)
        ->get();
    }

    public function ajukanIzin(array $data) {
        if (!$this->cekBatasHari($data['jenis_izin'])) {
            return 'Pengajuan melebihi batas hari yang diizinkan';
        }
        return izin::create([
            'karyawan_id' => $this->id,
            'jenis_izin' => $data['jenis_izin'],
            'tanggal' => $data['tanggal'],
            'keterangan' => $data['keterangan'],
            'status' => 'pending'
        ]);
    }

    public function setujuIzin(int $id) {}
    public function tolakIzin(int $id) {}

    public function cekBatasHari(string $jenis): bool {
        $max = $jenis === 'sakit' ? 3 : 1;
        $total = Izin::where('karyawan_id', $this->id)
        ->where('jenis_izin', $jenis)
        ->whereMonth('tanggal', now()->month)
        ->count();
        return $total < $max;
    }
}
