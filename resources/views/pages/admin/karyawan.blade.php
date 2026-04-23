@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
        'title' => 'SELAMAT DATANG, ADMIN',
        'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow p-6">

        {{-- Top --}}
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">
                Management Karyawan
            </h2>

            <button onclick="openModal('modalKaryawan')"
                class="bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah Karyawan
            </button>
        </div>

        {{-- Divider --}}
        <div class="border-b mb-4"></div>

        {{-- Table --}}
        <table class="w-full table-fixed text-sm text-gray-600">
            <thead>
                <tr class="text-gray-500 text-left">
                    <th class="py-3 font-medium w-24">Id</th>
                    <th class="py-3 font-medium">Nama</th>
                    <th class="py-3 font-medium">Divisi</th>
                    <th class="py-3 font-medium">Jabatan</th>
                    <th class="py-3 font-medium text-center w-40">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($karyawan as $index => $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3">{{ $item['id'] ?? 'KRY' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-3 font-medium">{{ $item['nama'] ?? '-' }}</td>
                        <td class="py-3">{{ $item['divisi'] ?? '-' }}</td>
                        <td class="py-3">{{ $item['jabatan'] ?? '-' }}</td>

                        <td class="py-3">
                            <div class="flex justify-center gap-2">
                                <button
                                    onclick="openModal('modalEditKaryawan{{ $index }}')"
                                    class="px-3 py-1 rounded bg-yellow-400 text-white text-xs font-semibold hover:bg-yellow-500 transition">
                                    Edit
                                </button>

                                <button
                                    onclick="openModal('modalDeleteKaryawan{{ $index }}')"
                                    class="px-3 py-1 rounded bg-red-500 text-white text-xs font-semibold hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-400">
                            Data karyawan belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Modal Tambah Karyawan --}}
        <x-modal id="modalKaryawan" title="Tambah Karyawan">
            <form class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        ID Karyawan
                    </label>

                    <input
                        type="text"
                        placeholder="Contoh: KRY001"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Nama Karyawan
                    </label>

                    <input
                        type="text"
                        placeholder="Contoh: Budi Santoso"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Divisi
                    </label>

                    <select
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Pilih Divisi</option>
                        <option value="IT">IT</option>
                        <option value="HRD">HRD</option>
                        <option value="Finance">Finance</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Digital Marketing">Digital Marketing</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Jabatan
                    </label>

                    <input
                        type="text"
                        placeholder="Contoh: Staff, Manager"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        onclick="closeModal('modalKaryawan')"
                        class="px-4 py-2 text-gray-600 hover:text-black">
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Simpan
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Edit & Delete --}}
        @foreach($karyawan as $index => $item)
            <x-modal id="modalEditKaryawan{{ $index }}" title="Edit Karyawan">
                <form class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Karyawan</label>
                        <input
                            type="text"
                            value="{{ $item['nama'] ?? '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Divisi</label>
                        <select
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="IT" {{ ($item['divisi'] ?? '') == 'IT' ? 'selected' : '' }}>IT</option>
                            <option value="HRD" {{ ($item['divisi'] ?? '') == 'HRD' ? 'selected' : '' }}>HRD</option>
                            <option value="Finance" {{ ($item['divisi'] ?? '') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Marketing" {{ ($item['divisi'] ?? '') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="Digital Marketing" {{ ($item['divisi'] ?? '') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jabatan</label>
                        <input
                            type="text"
                            value="{{ $item['jabatan'] ?? '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div class="flex flex-row gap-3 pt-2">
                        <button
                            type="button"
                            onclick="closeModal('modalEditKaryawan{{ $index }}')"
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

            <x-modal id="modalDeleteKaryawan{{ $index }}" title="Hapus Karyawan">
                <form class="space-y-5">
                    <p>
                        Apakah Anda yakin ingin menghapus karyawan
                        <span class="font-semibold">{{ $item['nama'] ?? '-' }}</span>?
                    </p>

                    <div class="flex flex-row gap-3 pt-2">
                        <button
                            type="button"
                            onclick="closeModal('modalDeleteKaryawan{{ $index }}')"
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