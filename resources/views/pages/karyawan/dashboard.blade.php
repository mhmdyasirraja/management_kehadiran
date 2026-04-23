@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, Yasir</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Pantau status kehadiran, riwayat absensi, dan informasi cuti Anda hari ini.
                </p>
            </div>

            <div class="text-sm text-gray-500">
                {{ now()->format('l, d F Y') }}
            </div>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- Status Hari Ini --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Status Hari Ini</p>
            <div class="mt-3 flex items-center justify-between">
                <h3 class="text-xl font-bold text-green-600">Hadir</h3>
                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                    Aktif
                </span>
            </div>
        </div>

        {{-- Jam Masuk Terakhir --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Jam Masuk Terakhir</p>
            <h3 class="text-xl font-bold text-gray-800 mt-3">08:05</h3>
        </div>

        {{-- Total Kehadiran --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Kehadiran</p>
            <h3 class="text-xl font-bold text-gray-800 mt-3">20 Hari</h3>
        </div>

        {{-- Sisa Cuti --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Sisa Cuti</p>
            <h3 class="text-xl font-bold text-blue-600 mt-3">5 Hari</h3>
        </div>

    </div>

    {{-- Grid Konten --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Absensi Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Absensi Terbaru</h2>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr class="text-left">
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold">Jam Masuk</th>
                            <th class="px-6 py-4 font-semibold">Jam Keluar</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">21 Feb 2026</td>
                            <td class="px-6 py-4">08:05</td>
                            <td class="px-6 py-4">17:00</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Hadir
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">20 Feb 2026</td>
                            <td class="px-6 py-4">08:20</td>
                            <td class="px-6 py-4">17:00</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                    Terlambat
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">19 Feb 2026</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                    Izin
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Panel Samping --}}
        <div class="space-y-6">

            {{-- Ringkasan Profil --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Profil</h2>

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Nama</span>
                        <span class="font-medium text-gray-800">Yasir</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Divisi</span>
                        <span class="font-medium text-gray-800">IT</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Jabatan</span>
                        <span class="font-medium text-gray-800">Staff</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Status</span>
                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                            Aktif
                        </span>
                    </div>
                </div>
            </div>


        </div>
    </div>

</div>

@endsection