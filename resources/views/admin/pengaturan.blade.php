@extends('layouts.sidebar', ['role' => 'admin'])

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
    'title' => 'SELAMAT DATANG, ADMIN',
    'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Grid --}}
    <div class="grid grid-cols-2 gap-6">

        {{-- JAM KERJA --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-700 mb-4">
                Jam Kerja
            </h2>

            <div class="space-y-4">

                <!-- Jam Masuk -->
                <div>
                    <label class="text-sm text-gray-600">Jam Masuk</label>
                    <input type="time" class="w-full mt-1 px-3 py-2 border rounded-lg">
                </div>

                <!-- Jam Pulang -->
                <div>
                    <label class="text-sm text-gray-600">Jam Pulang</label>
                    <input type="time" class="w-full mt-1 px-3 py-2 border rounded-lg">
                </div>

                <!-- Toleransi Telat -->
                <div>
                    <label class="text-sm text-gray-600">Toleransi Keterlambatan (menit)</label>
                    <input type="number" placeholder="Contoh: 15"
                        class="w-full mt-1 px-3 py-2 border rounded-lg">
                </div>

                <!-- Mode Jam -->
                <div>
                    <label class="text-sm text-gray-600">Pengaturan Jam Kerja</label>
                </div>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600">
                    Simpan
                </button>

            </div>

        </div>

        {{-- HARI LIBUR --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-700 mb-4">
                Hari Libur
            </h2>

            <div class="space-y-4">

                <!-- Pilih Tanggal -->
                <div>
                    <label class="text-sm text-gray-600">Tambah Hari Libur</label>
                    <input type="date" class="w-full mt-1 px-3 py-2 border rounded-lg">
                </div>

                <!-- Keterangan -->
                <div>
                    <label class="text-sm text-gray-600">Keterangan</label>
                    <input type="text" placeholder="Contoh: Hari Raya"
                        class="w-full mt-1 px-3 py-2 border rounded-lg">
                </div>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600">
                    Tambah
                </button>

                <!-- List Libur -->
                <div class="pt-4">
                    <h3 class="text-sm font-medium text-gray-600 mb-2">Daftar Hari Libur</h3>

                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>01 Jan 2026 - Tahun Baru</li>
                        <li>17 Aug 2026 - Hari Kemerdekaan</li>
                    </ul>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection