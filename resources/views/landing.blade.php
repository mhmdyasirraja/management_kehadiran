<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AbsenKu - Sistem Absensi Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    {{-- Header --}}
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="#" class="text-2xl font-extrabold tracking-tight text-gray-900">
                    Absen<span class="text-blue-600">Ku</span>
                </a>
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-white">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-white"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="grid lg:grid-cols-2 gap-14 items-center">

                {{-- Kiri --}}
                <div>
                    <span class="inline-flex items-center rounded-full bg-blue-50 px-4 py-2 text-sm font-medium text-blue-700 border border-blue-100">
                        Sistem Informasi Absensi
                    </span>

                    <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight text-gray-900">
                        Sistem absensi karyawan
                        <span class="text-blue-600">terintegrasi</span>
                    </h1>

                    <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-2xl">
                        Sistem ini digunakan untuk mencatat kehadiran karyawan, memantau keterlambatan,
                        serta mengelola pengajuan izin dan cuti secara terpusat.
                    </p>

                    <div class="mt-8">
                        <a href="/login"
                            class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-7 py-4 text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                            Masuk
                        </a>
                    </div>

                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                            <p class="text-2xl font-bold text-gray-900">Absensi</p>
                            <p class="mt-1 text-sm text-gray-500">pencatatan kehadiran harian</p>
                        </div>
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                            <p class="text-2xl font-bold text-gray-900">Perizinan</p>
                            <p class="mt-1 text-sm text-gray-500">pengajuan izin dan cuti</p>
                        </div>
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                            <p class="text-2xl font-bold text-gray-900">Laporan</p>
                            <p class="mt-1 text-sm text-gray-500">rekap kehadiran karyawan</p>
                        </div>
                    </div>
                </div>

                {{-- Kanan --}}
                <div class="relative">
                    <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-2xl shadow-gray-100">

                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-sm text-gray-500">Dashboard</p>
                                <h3 class="text-xl font-bold text-gray-900 mt-1">Ringkasan Kehadiran</h3>
                            </div>
                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                Hari Ini
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="rounded-2xl bg-blue-50 p-4">
                                <p class="text-sm text-gray-500">Hadir</p>
                                <p class="mt-2 text-2xl font-bold text-blue-700">128</p>
                            </div>
                            <div class="rounded-2xl bg-yellow-50 p-4">
                                <p class="text-sm text-gray-500">Terlambat</p>
                                <p class="mt-2 text-2xl font-bold text-yellow-600">12</p>
                            </div>
                            <div class="rounded-2xl bg-green-50 p-4">
                                <p class="text-sm text-gray-500">Izin</p>
                                <p class="mt-2 text-2xl font-bold text-green-600">8</p>
                            </div>
                            <div class="rounded-2xl bg-red-50 p-4">
                                <p class="text-sm text-gray-500">Tidak Hadir</p>
                                <p class="mt-2 text-2xl font-bold text-red-600">3</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Info --}}
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6">

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900">Absensi Harian</h3>
                    <p class="mt-3 text-sm text-gray-600">
                        Digunakan untuk mencatat jam masuk dan jam pulang karyawan setiap hari kerja.
                    </p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900">Pengajuan Izin</h3>
                    <p class="mt-3 text-sm text-gray-600">
                        Digunakan untuk mengajukan izin, sakit, atau cuti sesuai dengan ketentuan perusahaan.
                    </p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900">Laporan Kehadiran</h3>
                    <p class="mt-3 text-sm text-gray-600">
                        Menyediakan rekap kehadiran karyawan untuk keperluan administrasi dan evaluasi.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-gray-500">
            © 2026 Sistem Absensi Karyawan
        </div>
    </footer>

</body>
</html>