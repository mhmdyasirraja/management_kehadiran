@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
    'title' => 'SELAMAT DATANG, ADMIN',
    'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Filter --}}
    <div class="bg-white rounded-2xl p-6 px-8 shadow-sm">

        <div class="flex flex-wrap gap-4 items-center">

            <!-- Tanggal -->
            <input type="date"
                class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm w-48 focus:outline-none focus:ring-2 focus:ring-blue-400">

            <!-- Divisi -->
            <select
                class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm w-48 focus:outline-none focus:ring-2 focus:ring-blue-400">

                <option value="">Semua Divisi</option>
                <option value="it">IT</option>
                <option value="hrd">HRD</option>
                <option value="finance">Finance</option>
                <option value="marketing">Marketing</option>

            </select>

            <!-- Status -->
            <select
                class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm w-48 focus:outline-none focus:ring-2 focus:ring-blue-400">

                <option value="">Semua Status</option>
                <option value="hadir">Hadir</option>
                <option value="terlambat">Terlambat</option>
                <option value="izin">Izin</option>
                <option value="alpha">Alpha</option>

            </select>

            <!-- Button -->
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600">
                Filter
            </button>

            <button class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600">
                Export Excel
            </button>

        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl p-6 px-8 shadow-sm">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Laporan Kehadiran
        </h2>

        <div class="border-b mb-4"></div>

        <table class="w-full table-fixed text-sm text-gray-600">

            <thead>
                <tr class="text-gray-500 text-left">
                    <th class="py-3 w-[60px]">Id</th>
                    <th class="py-3">Nama</th>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Jam Masuk</th>
                    <th class="py-3">Jam Keluar</th>
                    <th class="py-3">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                <tr class="hover:bg-gray-50">
                    <td class="py-3">1</td>
                    <td class="py-3 font-medium">Yasir</td>
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
                    <td class="py-3">2</td>
                    <td class="py-3 font-medium">Andi</td>
                    <td class="py-3">21 Feb 2026</td>
                    <td class="py-3">08:30</td>
                    <td class="py-3">17:00</td>
                    <td class="py-3">
                        <span class="text-yellow-600 bg-yellow-100 px-2 py-1 rounded text-xs">
                            Terlambat
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="py-3">3</td>
                    <td class="py-3 font-medium">Budi</td>
                    <td class="py-3">21 Feb 2026</td>
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

</div>

@endsection