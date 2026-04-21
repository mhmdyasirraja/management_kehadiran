@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
    'title' => 'Selamat Datang, Yasir',
    'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Card Info --}}
    <div class="grid grid-cols-4 gap-6">

        {{-- Status Hari Ini --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Status Hari Ini</p>
            <h3 class="text-lg font-semibold text-green-600 mt-2">Hadir</h3>
        </div>

        {{-- Jam Masuk Terakhir --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Jam Masuk Terakhir</p>
            <h3 class="text-lg font-semibold mt-2">08:05</h3>
        </div>

        {{-- Total Kehadiran --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Total Kehadiran</p>
            <h3 class="text-lg font-semibold mt-2">20 Hari</h3>
        </div>

        {{-- Sisa Cuti --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Sisa Cuti</p>
            <h3 class="text-lg font-semibold mt-2">5 Hari</h3>
        </div>

    </div>

    {{-- Absensi Terbaru --}}
    <div class="bg-white rounded-2xl p-6 px-8 shadow-sm">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Absensi Terbaru
        </h2>

        <div class="border-b mb-4"></div>

        <table class="w-full table-fixed text-sm text-gray-600">

            <thead>
                <tr class="text-gray-500 text-left">
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Jam Masuk</th>
                    <th class="py-3">Jam Keluar</th>
                    <th class="py-3">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                <tr class="hover:bg-gray-50">
                    <td class="py-3">21 Feb 2026</td>
                    <td class="py-3">08:05</td>
                    <td class="py-3">17:00</td>
                    <td class="py-3">
                        <span class="text-green-600 bg-green-100 px-2 py-1 rounded text-xs">
                            Hadir
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="py-3">20 Feb 2026</td>
                    <td class="py-3">08:20</td>
                    <td class="py-3">17:00</td>
                    <td class="py-3">
                        <span class="text-yellow-600 bg-yellow-100 px-2 py-1 rounded text-xs">
                            Terlambat
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="py-3">19 Feb 2026</td>
                    <td class="py-3">-</td>
                    <td class="py-3">-</td>
                    <td class="py-3">
                        <span class="text-blue-600 bg-blue-100 px-2 py-1 rounded text-xs">
                            Izin
                        </span>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection