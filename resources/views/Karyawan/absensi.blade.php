@extends('layouts.sidebar', ['role' => 'karyawan'])

@section('content')

<div class="space-y-6">

    {{-- Header Absensi --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm flex justify-between items-center">

        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                21 April 2026 | 07:30
            </h2>

            {{-- STATUS --}}
            <p class="text-sm text-gray-500 mt-1">
                Status: <span class="text-yellow-600 font-medium">Belum Check In</span>
            </p>
        </div>

        {{-- BUTTON DINAMIS --}}
        <button class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600">
            Check In
        </button>

    </div>


    {{-- Riwayat --}}
    <div class="bg-white rounded-2xl p-6 px-8 shadow-sm">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Riwayat Absensi
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
                    <td class="py-3">20 April 2026</td>
                    <td class="py-3">08:05</td>
                    <td class="py-3">17:00</td>
                    <td class="py-3">
                        <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                            Hadir
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="py-3">19 April 2026</td>
                    <td class="py-3">08:30</td>
                    <td class="py-3">17:00</td>
                    <td class="py-3">
                        <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                            Terlambat
                        </span>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection