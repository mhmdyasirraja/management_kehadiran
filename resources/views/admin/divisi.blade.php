@extends('layouts.sidebar', ['role' => 'admin'])

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
    'title' => 'SELAMAT DATANG, ADMIN',
    'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Content --}}
    <div class="bg-white rounded-xl shadow p-6">

        <!-- Top Action -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold text-gray-700">Management Divisi</h2>

            <button onclick="openModal('modalDivisi')"
                class="bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah Divisi
            </button>
        </div>

        <!-- Table -->
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

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">1</td>
                    <td class="py-3 font-medium">IT</td>
                    <td class="py-3">10</td>
                    <td class="py-3">Divisi Teknologi & Sistem</td>
                    <td class="py-3">12 Feb 2026</td>
                    <td class="py-3 text-center space-x-3">
                        <button class="text-blue-500 text-sm hover:underline">Edit</button>
                        <button class="text-red-500 text-sm hover:underline">Delete</button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">2</td>
                    <td class="py-3 font-medium">HRD</td>
                    <td class="py-3">5</td>
                    <td class="py-3">Manajemen SDM</td>
                    <td class="py-3">10 Feb 2026</td>
                    <td class="py-3 text-center space-x-3">
                        <button class="text-blue-500 text-sm hover:underline">Edit</button>
                        <button class="text-red-500 text-sm hover:underline">Delete</button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">3</td>
                    <td class="py-3 font-medium">Finance</td>
                    <td class="py-3">7</td>
                    <td class="py-3">Keuangan & Akuntansi</td>
                    <td class="py-3">08 Feb 2026</td>
                    <td class="py-3 text-center space-x-3">
                        <button class="text-blue-500 text-sm hover:underline">Edit</button>
                        <button class="text-red-500 text-sm hover:underline">Delete</button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">4</td>
                    <td class="py-3 font-medium">Marketing</td>
                    <td class="py-3">6</td>
                    <td class="py-3">Promosi & Branding</td>
                    <td class="py-3">05 Feb 2026</td>
                    <td class="py-3 text-center space-x-3">
                        <button class="text-blue-500 text-sm hover:underline">Edit</button>
                        <button class="text-red-500 text-sm hover:underline">Delete</button>
                    </td>
                </tr>

            </tbody>

        </table>

        <x-modal id="modalDivisi" title="Tambah Divisi">

            <form class="space-y-5">

                <!-- Nama Divisi -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Nama Divisi
                    </label>

                    <input type="text"
                        placeholder="Contoh: IT, HRD, Finance"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Deskripsi
                    </label>

                    <textarea rows="3"
                        placeholder="Contoh: Mengelola sistem dan infrastruktur perusahaan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md 
                       focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- Info -->
                <p class="text-xs text-gray-400">
                    Nomor divisi dibuat otomatis oleh sistem.
                </p>

                <!-- Action -->
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button"
                        onclick="closeModal('modalDivisi')"
                        class="px-4 py-2 text-gray-600 hover:text-black">
                        Batal
                    </button>

                    <button type="button"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Simpan
                    </button>
                </div>

            </form>

        </x-modal>

    </div>

</div>

@endsection