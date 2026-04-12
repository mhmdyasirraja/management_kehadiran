@extends('layouts.sidebar', ['role' => 'karyawan'])

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ now()->format('d F Y') }} | {{ now()->format('H:i') }}
        </h2>
    </div>

    <!-- Title -->
    <h2 class="text-lg font-semibold text-gray-700 mb-4">
        Perizinan
    </h2>

    <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm rounded-lg p-4 mb-4">

        <p class="font-medium mb-1">Catatan Perizinan:</p>

        <ul class="list-disc ml-5 space-y-1">
            <li><strong>Cuti:</strong> diajukan minimal 1 minggu sebelum hari H dan paling lambat 1 hari sebelum hari H.</li>
            <li><strong>Sakit:</strong> surat sakit diajukan maksimal 3 hari setelah hari H.</li>
        </ul>

    </div>

    {{-- Card Perizinan --}}
    <div class="bg-white rounded-2xl p-6 px-8 shadow-sm">

        <!-- Top -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">
                Perizinan
            </h2>

            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600">
                Ajukan Izin
            </button>
        </div>

        <div class="border-b mb-4"></div>

        <!-- Table -->
        <table class="w-full table-fixed text-sm text-gray-600">

            <thead>
                <tr class="text-gray-500 text-left">
                    <th class="py-3">Jenis</th>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Status</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                <tr class="hover:bg-gray-50">
                    <td class="py-3">Cuti</td>
                    <td class="py-3">20 - 22 April 2026</td>
                    <td class="py-3">
                        <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                            Pending
                        </span>
                    </td>
                    <td class="py-3 text-center">
                        <button class="text-red-500 hover:underline text-sm">
                            Batalkan
                        </button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="py-3">Sakit</td>
                    <td class="py-3">18 April 2026</td>
                    <td class="py-3">
                        <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                            Disetujui
                        </span>
                    </td>
                    <td class="py-3 text-center text-gray-400">
                        -
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="py-3">Izin</td>
                    <td class="py-3">15 April 2026</td>
                    <td class="py-3">
                        <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">
                            Ditolak
                        </span>
                    </td>
                    <td class="py-3 text-center text-gray-400">
                        -
                    </td>
                </tr>

                <!-- Empty State -->
                {{--
                <tr>
                    <td colspan="4" class="text-center py-10 text-gray-400">
                        Belum ada pengajuan izin
                    </td>
                </tr>
                --}}

            </tbody>

        </table>

    </div>

</div>

@endsection