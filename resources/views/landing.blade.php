<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AbsenKu - Sistem Absensi Sederhana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-white font-inter">

    <!-- Header -->
    <header class="border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-900">Absen<span class="text-blue-600">Ku</span></div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#fitur" class="text-gray-600 hover:text-blue-600 font-medium">Fitur</a>
                    <a href="#harga" class="text-gray-600 hover:text-blue-600 font-medium">Harga</a>
                    <a href="#kontak" class="text-gray-600 hover:text-blue-600 font-medium">Kontak</a>
                </nav>
                <a href="/login" class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Masuk
                </a>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="py-24 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-full mb-8">
                        <i class="fas fa-star mr-2"></i>
                        Digunakan 5.000+ perusahaan
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Absensi Karyawan
                        <span class="text-blue-600">Yang Mudah</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Sistem absensi online yang simpel, akurat, dan terintegrasi.
                        Catat kehadiran karyawan dalam 3 detik.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#demo" class="px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                            <i class="fas fa-rocket mr-2"></i>
                            Coba Gratis 14 Hari
                        </a>
                        <a href="#fitur" class="px-8 py-4 border-2 border-gray-200 text-gray-900 font-semibold rounded-xl hover:bg-gray-50 transition-all">
                            Lihat Fitur
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="fitur" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Fitur Utama</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Semua yang Anda butuhkan dalam satu platform
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-mobile-screen text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Absensi HP</h3>
                    <p class="text-gray-600 text-center mb-8">Scan QR atau Face ID dari HP karyawan. Tanpa hardware mahal.</p>
                    <div class="text-center">
                        <span class="text-blue-600 font-semibold">Mulai dari Rp25rb/bln</span>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-fingerprint text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Sidik Jari</h3>
                    <p class="text-gray-600 text-center mb-8">Mesin sidik jari murah Rp500rb. Setup 5 menit.</p>
                    <div class="text-center">
                        <span class="text-green-600 font-semibold">Hardware + Software</span>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-chart-bar text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Laporan Auto</h3>
                    <p class="text-gray-600 text-center mb-8">Excel, PDF, WhatsApp. Kirim otomatis setiap pagi.</p>
                    <div class="text-center">
                        <span class="text-purple-600 font-semibold">Export 1 klik</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="harga" class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Harga Terjangkau</h2>
                <p class="text-xl text-gray-600">Mulai dari harga kopi sehari</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl p-8 shadow-lg border">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Basic</h3>
                    <div class="text-4xl font-bold text-blue-600 mb-2">Rp 25.000</div>
                    <div class="text-gray-600 mb-8">/bulan</div>
                    <ul class="space-y-3 mb-8 text-gray-700">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>50 karyawan</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Absensi HP</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Laporan Excel</li>
                    </ul>
                    <a href="#" class="w-full block py-3 bg-blue-600 text-white font-semibold rounded-xl text-center hover:bg-blue-700">Pilih Basic</a>
                </div>

                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-8 shadow-2xl text-white relative">
                    <div class="absolute top-0 w-full bg-white/20 py-2 rounded-t-2xl text-center font-bold text-sm">PAKET TERLARIS</div>
                    <h3 class="text-2xl font-bold mb-4">Pro</h3>
                    <div class="text-4xl font-bold mb-2">Rp 49.000</div>
                    <div class="mb-8">/bulan</div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center"><i class="fas fa-check mr-3"></i>Unlimited karyawan</li>
                        <li class="flex items-center"><i class="fas fa-check mr-3"></i>Sidik jari + HP</li>
                        <li class="flex items-center"><i class="fas fa-check mr-3"></i>Laporan WA/Email</li>
                    </ul>
                    <a href="#" class="w-full block py-3 bg-white text-blue-600 font-bold rounded-xl text-center hover:bg-gray-100 shadow-xl">Pilih Pro</a>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg border">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Enterprise</h3>
                    <div class="text-4xl font-bold text-gray-900 mb-2">Rp 99.000</div>
                    <div class="text-gray-600 mb-8">/bulan</div>
                    <ul class="space-y-3 mb-8 text-gray-700">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Semua fitur Pro</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>API + Custom</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Support prioritas</li>
                    </ul>
                    <a href="#kontak" class="w-full block py-3 border-2 border-gray-300 text-gray-900 font-semibold rounded-xl text-center hover:bg-gray-50">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="demo" class="py-24 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl lg:text-5xl font-bold mb-6">Siap Menghemat Waktu?</h2>
            <p class="text-xl mb-12 opacity-90">Daftar sekarang dan dapatkan akses instan ke sistem absensi terbaik</p>
            <a href="#" class="inline-flex items-center px-10 py-5 bg-white text-blue-600 text-xl font-bold rounded-2xl hover:shadow-2xl hover:scale-105 transition-all shadow-xl">
                <i class="fas fa-check-circle mr-3 text-2xl"></i>
                Mulai Gratis 14 Hari
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h3 class="text-2xl font-bold mb-4">AbsenKu</h3>
                    <p class="text-gray-400 mb-6">Absensi online untuk UKM dan perusahaan. Simpel. Akurat. Terjangkau.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-6">Fitur</h4>
                    <div class="space-y-3 text-gray-400">
                        <a href="#" class="hover:text-white block">Absensi HP</a>
                        <a href="#" class="hover:text-white block">Sidik Jari</a>
                        <a href="#" class="hover:text-white block">Laporan</a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-6">Perusahaan</h4>
                    <div class="space-y-3 text-gray-400">
                        <a href="#" class="hover:text-white block">Tentang</a>
                        <a href="#" class="hover:text-white block">Bantuan</a>
                        <a href="#" class="hover:text-white block">Kebijakan</a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-6">Kontak</h4>
                    <div class="text-gray-400 space-y-2">
                        <div class="flex items-center"><i class="fas fa-phone mr-3 text-blue-400"></i>+62 812-3456-7890</div>
                        <div class="flex items-center"><i class="fas fa-envelope mr-3 text-blue-400"></i>hello@absenku.com</div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-sm">
                © 2024 AbsenKu. Semua hak dilindungi.
            </div>
        </div>
    </footer>

</body>

</html>