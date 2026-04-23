@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Perizinan Karyawan</h1>
            </div>

            <div class="text-sm text-gray-500">
                {{ now()->format('d F Y') }} • {{ now()->format('H:i') }}
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Total Pengajuan</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-2">3</h3>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
            <h3 class="text-2xl font-bold text-yellow-500 mt-2">1</h3>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">Disetujui / Ditolak</p>
            <h3 class="text-2xl font-bold text-green-600 mt-2">2</h3>
        </div>
    </div>

    {{-- Informasi --}}
    <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-2xl p-5">
        <h2 class="text-sm font-semibold mb-2">Informasi Pengajuan</h2>
        <ul class="list-disc ml-5 space-y-1 text-sm">
            <li><strong>Cuti:</strong> diajukan minimal 1 minggu sebelum hari H dan paling lambat 1 hari sebelum hari H.</li>
            <li><strong>Sakit:</strong> surat sakit diajukan maksimal 3 hari setelah hari H.</li>
            <li><strong>Izin:</strong> lampirkan keterangan yang jelas agar proses persetujuan lebih cepat.</li>
        </ul>
    </div>

    {{-- Card Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header Table --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-6 py-5 border-b border-gray-100">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Riwayat Pengajuan Perizinan</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Daftar seluruh pengajuan izin yang sudah dibuat.
                </p>
            </div>

            <button onclick="openModal('izinModal')"
                class="inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                + Ajukan Izin
            </button>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-500">
                    <tr class="text-left">
                        <th class="px-6 py-4 font-semibold">Jenis</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Keterangan</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">Cuti</td>
                        <td class="px-6 py-4">20 - 22 April 2026</td>
                        <td class="px-6 py-4">Keperluan keluarga</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                Menunggu
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="openModal('modalCancel1')"
                                class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-100 transition">
                                Batalkan
                            </button>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">Sakit</td>
                        <td class="px-6 py-4">18 April 2026</td>
                        <td class="px-6 py-4">Demam dan istirahat di rumah</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                Disetujui
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-400">
                            -
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">Izin</td>
                        <td class="px-6 py-4">15 April 2026</td>
                        <td class="px-6 py-4">Keperluan pribadi</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                Ditolak
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-400">
                            -
                        </td>
                    </tr>

                    {{--
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                            Belum ada pengajuan izin.
                        </td>
                    </tr>
                    --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Ajukan Izin --}}
    <x-modal id="izinModal" title="Ajukan Perizinan">
        <form action="#" method="POST" class="space-y-5" enctype="multipart/form-data">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Izin</label>
                <select name="jenis"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    <option value="">Pilih jenis izin</option>
                    <option value="cuti">Cuti</option>
                    <option value="sakit">Sakit</option>
                    <option value="izin">Izin</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="4"
                    placeholder="Tuliskan alasan pengajuan izin dengan jelas..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition resize-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti (Opsional)</label>
                <input type="file" name="bukti"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-400 mt-2">
                    Format file yang disarankan: PDF, JPG, PNG.
                </p>
            </div>

            <div class="flex justify-end gap-3 pt-3">
                <button type="button"
                    onclick="closeModal('izinModal')"
                    class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>

                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm font-medium">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </x-modal>

    {{-- Modal Batalkan --}}
    <x-modal id="modalCancel1" title="Batalkan Pengajuan">
        <form action="#" method="POST" class="space-y-5">
            @csrf

            <p class="text-sm text-gray-600">
                Apakah Anda yakin ingin <span class="font-semibold text-red-600">membatalkan</span> pengajuan izin ini?
            </p>

            <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-sm text-red-700">
                Pengajuan yang dibatalkan tidak dapat diproses kembali dan perlu diajukan ulang jika masih diperlukan.
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button
                    type="button"
                    onclick="closeModal('modalCancel1')"
                    class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                    Kembali
                </button>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-xl bg-red-600 text-white hover:bg-red-700 transition font-medium">
                    Ya, Batalkan
                </button>
            </div>
        </form>
    </x-modal>

</div>

@endsection