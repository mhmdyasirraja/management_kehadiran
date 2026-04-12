@extends('layouts.sidebar', ['role' => 'admin'])

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    @include('components.header_card', [
    'title' => 'SELAMAT DATANG, ADMIN',
    'subtitle' => now()->format('l, d F Y')
    ])

    {{-- CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        @include('components.card', [
        'title' => 'Total Karyawan',
        'value' => '3'
        ])

        @include('components.card', [
        'title' => 'Hadir Hari Ini',
        'value' => '1',
        'color' => 'text-green-600'
        ])

        @include('components.card', [
        'title' => 'Izin / Cuti',
        'value' => '1',
        'color' => 'text-yellow-500'
        ])

        @include('components.card', [
        'title' => 'Tidak Hadir',
        'value' => '10',
        'color' => 'text-red-500'
        ])

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow-sm p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">
                Absensi Terbaru
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">

                <thead class="text-gray-800 border-b text-xs uppercase">
                    <tr>
                        <th class="py-3">No</th>
                        <th class="py-3">Nama</th>
                        <th class="py-3 text-center">Tanggal</th>
                        <th class="py-3 text-center">Masuk</th>
                        <th class="py-3 text-center">Keluar</th>
                        <th class="py-3 text-center">Status</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 font-medium">3312511005</td>
                        <td class="py-3 font-medium">Budi Santoso</td>
                        <td class="text-center">21 Feb 2026</td>
                        <td class="text-center">08:00</td>
                        <td class="text-center">17:00</td>
                        <td class="text-center">
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-600">
                                Hadir
                            </span>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 font-medium">3312511006</td>
                        <td class="py-3 font-medium">Andi Wijaya</td>
                        <td class="text-center">21 Feb 2026</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-600">
                                Tidak Hadir
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-medium">3312511007</td>
                        <td class="py-3 font-medium">Siti Rahma</td>
                        <td class="text-center">21 Feb 2026</td>
                        <td class="text-center">08:15</td>
                        <td class="text-center">17:05</td>
                        <td class="text-center">
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-600">
                                Izin
                            </span>
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection