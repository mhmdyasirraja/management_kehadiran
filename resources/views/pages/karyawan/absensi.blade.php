@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    @include('components.header_card', [
    'title' => 'Absensi Karyawan',
    'subtitle' => now()->format('l, d F Y')
    ])

    {{-- ABSENSI --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm flex justify-between items-center">

        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                {{ now()->format('d F Y | H:i') }}
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Status:
                <span class="text-yellow-600 font-medium">
                    Belum Check In
                </span>
            </p>
        </div>

        <button class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600">
            Check In
        </button>

    </div>

    {{-- RIWAYAT --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Riwayat Absensi
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-600">

                <thead class="border-b text-gray-500 text-left">
                    <tr>
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
                        <td>
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                                Hadir
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="py-3">19 April 2026</td>
                        <td class="py-3">08:30</td>
                        <td class="py-3">17:00</td>
                        <td>
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                                Terlambat
                            </span>
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection