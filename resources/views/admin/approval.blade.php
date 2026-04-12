@extends('layouts.sidebar', ['role' => 'admin'])

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
    'title' => 'SELAMAT DATANG, ADMIN',
    'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow p-6">

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

        <!-- Divider -->
        <div class="border-b mb-4"></div>

        <!-- Table -->
        <table class="w-full table-fixed text-sm text-gray-600">

            <thead>
                <tr class="text-gray-500 text-left">
                    <th class="py-3 font-medium w-[60px]">Id</th>
                    <th class="py-3 font-medium">Nama</th>
                    <th class="py-3 font-medium">Tanggal</th>
                    <th class="py-3 font-medium">Status</th>
                    <th class="py-3 font-medium text-center w-[120px]">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">1</td>
                    <td class="py-3 font-medium">Yasir</td>
                    <td class="py-3">20 Feb 2026</td>
                    <td class="py-3">
                        <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-600">
                            Pending
                        </span>
                    </td>
                    <td class="py-3 text-center space-x-3">
                        <button class="text-green-500 text-sm hover:underline">Approve</button>
                        <button class="text-red-500 text-sm hover:underline">Reject</button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">2</td>
                    <td class="py-3 font-medium">Andi</td>
                    <td class="py-3">19 Feb 2026</td>
                    <td class="py-3">
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-600">
                            Approved
                        </span>
                    </td>
                    <td class="py-3 text-center text-gray-400">
                        -
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">3</td>
                    <td class="py-3 font-medium">Budi</td>
                    <td class="py-3">18 Feb 2026</td>
                    <td class="py-3">
                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-600">
                            Rejected
                        </span>
                    </td>
                    <td class="py-3 text-center text-gray-400">
                        -
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">4</td>
                    <td class="py-3 font-medium">Sinta</td>
                    <td class="py-3">17 Feb 2026</td>
                    <td class="py-3">
                        <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-600">
                            Pending
                        </span>
                    </td>
                    <td class="py-3 text-center space-x-3">
                        <button class="text-green-500 text-sm hover:underline">Approve</button>
                        <button class="text-red-500 text-sm hover:underline">Reject</button>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection