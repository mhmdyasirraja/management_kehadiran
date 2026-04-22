@extends('layouts.app')

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

            <button onclick="openModal('izinModal')"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600">
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

        <x-modal id="izinModal" title="Ajukan Izin">

            <form action="#" method="POST" class="space-y-5">
                @csrf

                <!-- Jenis Izin -->
                <div>
                    <label class="text-xs text-gray-400">Jenis Izin</label>
                    <select name="jenis"
                        class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                        <option value="">Pilih jenis izin</option>
                        <option value="cuti">Cuti</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-gray-400">Dari</label>
                        <input type="date" name="tanggal"
                            class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="text-xs text-gray-400">Sampai</label>
                        <input type="date" name="sampai"
                            class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                    </div>
                </div>

                <!-- Keterangan -->
                <div>
                    <label class="text-xs text-gray-400">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                        placeholder="Contoh: keperluan keluarga, sakit, dll..."
                        class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-400 focus:outline-none transition resize-none"></textarea>
                </div>

                <!-- Upload (opsional) -->
                <div>
                    <label class="text-xs text-gray-400">Upload Bukti (opsional)</label>
                    <input type="file"
                        class="w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                </div>

                <!-- Button -->
                <div class="flex justify-end gap-3 pt-3">
                    <button type="button"
                        onclick="closeModal('izinModal')"
                        class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-100 transition">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                        Kirim
                    </button>
                </div>

            </form>

        </x-modal>

    </div>

</div>

@endsection