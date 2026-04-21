@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
    'title' => 'SELAMAT DATANG, ADMIN',
    'subtitle' => now()->format('l, d F Y')
    ])

    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Perizinan
        </h2>

        {{-- Info --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm rounded-lg p-4 mb-6">
            <p class="font-medium mb-2">Catatan Perizinan:</p>
            <ul class="list-disc ml-5 space-y-1">
                <li><strong>Cuti:</strong> diajukan minimal 1 minggu sebelum hari H.</li>
                <li><strong>Sakit:</strong> maksimal 3 hari setelah hari H.</li>
            </ul>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-600">

                <thead class="border-b text-gray-500 text-left">
                    <tr>
                        <th class="py-3 w-[60px]">Id</th>
                        <th class="py-3">Nama</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-center w-[120px]">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    <tr class="hover:bg-gray-50">
                        <td class="py-3">1</td>
                        <td class="py-3 font-medium">Yasir</td>
                        <td class="py-3">20 Feb 2026</td>
                        <td>
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-600">
                                Pending
                            </span>
                        </td>
                        <td class="text-center space-x-3">
                            <button class="text-green-500 hover:underline">Approve</button>
                            <button class="text-red-500 hover:underline">Reject</button>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="py-3">2</td>
                        <td class="py-3 font-medium">Andi</td>
                        <td class="py-3">19 Feb 2026</td>
                        <td>
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-600">
                                Approved
                            </span>
                        </td>
                        <td class="text-center text-gray-400">-</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="py-3">3</td>
                        <td class="py-3 font-medium">Budi</td>
                        <td class="py-3">18 Feb 2026</td>
                        <td>
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-600">
                                Rejected
                            </span>
                        </td>
                        <td class="text-center text-gray-400">-</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="py-3">4</td>
                        <td class="py-3 font-medium">Sinta</td>
                        <td class="py-3">17 Feb 2026</td>
                        <td>
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-600">
                                Pending
                            </span>
                        </td>
                        <td class="text-center space-x-3">
                            <button class="text-green-500 hover:underline">Approve</button>
                            <button class="text-red-500 hover:underline">Reject</button>
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection