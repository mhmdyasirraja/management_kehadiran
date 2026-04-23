@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
        'title' => 'SELAMAT DATANG, ADMIN',
        'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Content --}}
    <div class="bg-white rounded-xl shadow p-6">

        {{-- Top Action --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold text-gray-700">Management Divisi</h2>

            <button onclick="openModal('modalDivisi')" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah Divisi
            </button>
        </div>

        {{-- Table --}}
        <table class="w-full text-sm text-gray-600">
            <thead>
                <tr class="text-left text-gray-500">
                    <th class="py-3 font-medium">No</th>
                    <th class="py-3 font-medium">Nama Divisi</th>
                    <th class="py-3 font-medium">Jumlah Karyawan</th>
                    <th class="py-3 font-medium">Deskripsi</th>
                    <th class="py-3 font-medium">Tanggal Dibuat</th>
                    <th class="py-3 font-medium text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($divisi as $index => $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3">{{ $index + 1 }}</td>
                        <td class="py-3 font-medium">{{ $item['nama'] ?? '-' }}</td>
                        <td class="py-3">{{ $item['jumlah'] ?? 0 }}</td>
                        <td class="py-3">{{ $item['deskripsi'] ?? '-' }}</td>
                        <td class="py-3">{{ $item['tanggal'] ?? '-' }}</td>

                        <td class="py-3">
                            <div class="flex justify-center gap-2">
                                <button
                                    onclick="openModal('modalEditDivisi{{ $index }}')"
                                    class="px-3 py-1 rounded bg-yellow-400 text-white text-xs font-semibold hover:bg-yellow-500 transition">
                                    Edit
                                </button>

                                <button
                                    onclick="openModal('modalDeleteDivisi{{ $index }}')"
                                    class="px-3 py-1 rounded bg-red-500 text-white text-xs font-semibold hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-400">
                            Data divisi belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Modal Tambah Divisi --}}
        <x-modal id="modalDivisi" title="Tambah Divisi">
            <form class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Nama Divisi
                    </label>

                    <input
                        type="text"
                        placeholder="Contoh: IT, HRD, Finance"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Jumlah Karyawan
                    </label>

                    <input
                        type="number"
                        min="0"
                        placeholder="Contoh: 10"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Deskripsi
                    </label>

                    <textarea
                        rows="3"
                        placeholder="Contoh: Mengelola sistem dan infrastruktur perusahaan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <p class="text-xs text-gray-400">
                    Nomor divisi dibuat otomatis oleh sistem.
                </p>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        onclick="closeModal('modalDivisi')"
                        class="px-4 py-2 text-gray-600 hover:text-black">
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Edit & Delete untuk setiap divisi --}}
        @foreach($divisi as $index => $item)
            <x-modal id="modalEditDivisi{{ $index }}" title="Edit Divisi">
                <form class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Divisi</label>
                        <input
                            type="text"
                            value="{{ $item['nama'] ?? '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jumlah Karyawan</label>
                        <input
                            type="number"
                            min="0"
                            value="{{ $item['jumlah'] ?? 0 }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi</label>
                        <textarea
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ $item['deskripsi'] ?? '' }}</textarea>
                    </div>

                    <div class="flex flex-row gap-3 pt-2">
                        <button
                            type="button"
                            onclick="closeModal('modalEditDivisi{{ $index }}')"
                            class="px-4 py-2 text-gray-600 hover:text-black w-1/2 border border-gray-200 rounded">
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-yellow-500 text-white rounded w-1/2 hover:bg-yellow-600">
                            Simpan
                        </button>
                    </div>
                </form>
            </x-modal>

            <x-modal id="modalDeleteDivisi{{ $index }}" title="Hapus Divisi">
                <form class="space-y-5">
                    <p>
                        Apakah Anda yakin ingin menghapus divisi
                        <span class="font-semibold">{{ $item['nama'] ?? '-' }}</span>?
                    </p>

                    <div class="flex flex-row gap-3 pt-2">
                        <button
                            type="button"
                            onclick="closeModal('modalDeleteDivisi{{ $index }}')"
                            class="px-4 py-2 text-gray-600 hover:text-black w-1/2 border border-gray-200 rounded">
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded w-1/2 hover:bg-red-700">
                            Hapus
                        </button>
                    </div>
                </form>
            </x-modal>
        @endforeach

    </div>
</div>
@endsection