@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
    'title' => 'Riwayat Absensi',
    'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Filter --}}
    <div class="bg-white rounded-2xl p-6 px-8 shadow-sm">

        <div class="flex flex-wrap gap-4 items-center">

            <!-- Dari -->
            <input type="date"
                class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm w-48">

            <!-- Sampai -->
            <input type="date"
                class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm w-48">

            <!-- Status -->
            <select
                class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm w-48">

                <option value="">Semua Status</option>
                <option value="hadir">Hadir</option>
                <option value="terlambat">Terlambat</option>
                <option value="izin">Izin</option>
                <option value="alpha">Tidak Hadir</option>

            </select>

            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600">
                Filter
            </button>

        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl p-6 px-8 shadow-sm">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Riwayat Kehadiran
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
                    <td class="py-3">21 April 2026</td>
                    <td class="py-3">08:05</td>
                    <td class="py-3">17:00</td>
                    <td class="py-3">
                        <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                            Hadir
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="py-3">20 April 2026</td>
                    <td class="py-3">08:25</td>
                    <td class="py-3">17:00</td>
                    <td class="py-3">
                        <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                            Terlambat
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="py-3">19 April 2026</td>
                    <td class="py-3">-</td>
                    <td class="py-3">-</td>
                    <td class="py-3">
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs">
                            Izin
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="py-3">18 April 2026</td>
                    <td class="py-3">-</td>
                    <td class="py-3">-</td>
                    <td class="py-3">
                        <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">
                            Tidak Hadir
                        </span>
                    </td>
                </tr>

                {{-- Empty State --}}
                {{--
                <tr>
                    <td colspan="4" class="text-center py-10 text-gray-400">
                        Tidak ada data
                    </td>
                </tr>
                --}}

            </tbody>

        </table>

    </div>

</div>

@endsection