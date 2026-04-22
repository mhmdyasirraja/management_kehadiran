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
                        <th class="py-3 w-16">Id</th>
                        <th class="py-3">Nama</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-center w-48">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    <tr class="hover:bg-gray-50">
                        <td class="py-3">1</td>
                        <td class="py-3 font-medium">Yasir</td>
                        <td class="py-3">20 Feb 2026</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-600">
                                Pending
                            </span>
                        </td>
                        <td class="py-3 text-center">
                            <div class="flex flex-row justify-center items-center gap-2">
                                <button onclick="openModal('modalApprove1')"
                                    class="inline-flex px-3 py-1 rounded bg-green-500 text-white text-xs font-semibold hover:bg-green-600 transition">
                                    Setuju
                                </button>
                                <button onclick="openModal('modalReject1')"
                                    class="inline-flex px-3 py-1 rounded bg-red-500 text-white text-xs font-semibold hover:bg-red-600 transition">
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="py-3">2</td>
                        <td class="py-3 font-medium">Andi</td>
                        <td class="py-3">19 Feb 2026</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-600">
                                Approved
                            </span>
                        </td>
                        <td class="py-3 text-center text-gray-400">-</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="py-3">3</td>
                        <td class="py-3 font-medium">Budi</td>
                        <td class="py-3">18 Feb 2026</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-600">
                                Rejected
                            </span>
                        </td>
                        <td class="py-3 text-center text-gray-400">-</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="py-3">4</td>
                        <td class="py-3 font-medium">Sinta</td>
                        <td class="py-3">17 Feb 2026</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-600">
                                Pending
                            </span>
                        </td>
                        <td class="py-3 text-center">
                            <div class="flex flex-row justify-center items-center gap-2">
                                <button onclick="openModal('modalApprove4')"
                                    class="inline-flex px-3 py-1 rounded bg-green-500 text-white text-xs font-semibold hover:bg-green-600 transition">
                                    Setujui
                                </button>
                                <button onclick="openModal('modalReject4')"
                                    class="inline-flex px-3 py-1 rounded bg-red-500 text-white text-xs font-semibold hover:bg-red-600 transition">
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>

        {{-- Modal Setujui 1 --}}
        <x-modal id="modalApprove1" title="Konfirmasi Setujui Perizinan">
            <form class="space-y-5">
                <p>Apakah Anda yakin ingin <span class="font-semibold text-green-600">menyetujui</span> permohonan perizinan ini?</p>
                <div class="flex flex-row gap-3 pt-2 w-full">
                    <div class="w-1/2">
                        <button type="button" onclick="closeModal('modalApprove1')" class="w-full px-4 py-2 text-gray-600 hover:text-black border border-gray-200 rounded">
                            Batal
                        </button>
                    </div>
                    <div class="w-1/2">
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Setujui
                        </button>
                    </div>
                </div>
            </form>
        </x-modal>

        {{-- Modal Tolak 1 --}}
        <x-modal id="modalReject1" title="Konfirmasi Tolak Perizinan">
            <form class="space-y-5">
                <p>Apakah Anda yakin ingin <span class="font-semibold text-red-600">menolak</span> permohonan perizinan ini?</p>
                <div class="flex flex-row gap-3 pt-2 w-full">
                    <div class="w-1/2">
                        <button type="button" onclick="closeModal('modalReject1')" class="w-full px-4 py-2 text-gray-600 hover:text-black border border-gray-200 rounded">
                            Batal
                        </button>
                    </div>
                    <div class="w-1/2">
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Tolak
                        </button>
                    </div>
                </div>
            </form>
        </x-modal>

        {{-- Modal Setujui 4 --}}
        <x-modal id="modalApprove4" title="Konfirmasi Setujui Perizinan">
            <form class="space-y-5">
                <p>Apakah Anda yakin ingin <span class="font-semibold text-green-600">menyetujui</span> permohonan perizinan ini?</p>
                <div class="flex flex-row gap-3 pt-2 w-full">
                    <div class="w-1/2">
                        <button type="button" onclick="closeModal('modalApprove4')" class="w-full px-4 py-2 text-gray-600 hover:text-black border border-gray-200 rounded">
                            Batal
                        </button>
                    </div>
                    <div class="w-1/2">
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Setujui
                        </button>
                    </div>
                </div>
            </form>
        </x-modal>

        {{-- Modal Tolak 4 --}}
        <x-modal id="modalReject4" title="Konfirmasi Tolak Perizinan">
            <form class="space-y-5">
                <p>Apakah Anda yakin ingin <span class="font-semibold text-red-600">menolak</span> permohonan perizinan ini?</p>
                <div class="flex flex-row gap-3 pt-2 w-full">
                    <div class="w-1/2">
                        <button type="button" onclick="closeModal('modalReject4')" class="w-full px-4 py-2 text-gray-600 hover:text-black border border-gray-200 rounded">
                            Batal
                        </button>
                    </div>
                    <div class="w-1/2">
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Tolak
                        </button>
                    </div>
                </div>
            </form>
        </x-modal>

    </div>

</div>

@endsection