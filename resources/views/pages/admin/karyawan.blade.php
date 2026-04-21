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

        <!-- Top -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">
                Management Karyawan
            </h2>

            <button onclick="openModal('modalKaryawan')"
                class="bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah Karyawan
            </button>
        </div>

        <!-- Divider -->
        <div class="border-b mb-4"></div>

        <!-- Table -->
        <table class="w-full table-fixed text-sm text-gray-600">

            <thead>
                <tr class="text-gray-500 text-left">
                    <th class="py-3 font-medium w-[60px]">Id</th>
                    <th class="py-3 font-medium">Nama</th>
                    <th class="py-3 font-medium">Divisi</th>
                    <th class="py-3 font-medium">Jabatan</th>
                    <th class="py-3 font-medium text-center w-[120px]">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">1</td>
                    <td class="py-3 font-medium">Muhammad Yasir</td>
                    <td class="py-3">IT</td>
                    <td class="py-3">Backend Developer</td>
                    <td class="py-3 text-center space-x-3">
                        <button class="text-blue-500 text-sm hover:underline">Edit</button>
                        <button class="text-red-500 text-sm hover:underline">Delete</button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">2</td>
                    <td class="py-3 font-medium">Andi</td>
                    <td class="py-3">HRD</td>
                    <td class="py-3">HR Staff</td>
                    <td class="py-3 text-center space-x-3">
                        <button class="text-blue-500 text-sm hover:underline">Edit</button>
                        <button class="text-red-500 text-sm hover:underline">Delete</button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">3</td>
                    <td class="py-3 font-medium">Budi</td>
                    <td class="py-3">Finance</td>
                    <td class="py-3">Accountant</td>
                    <td class="py-3 text-center space-x-3">
                        <button class="text-blue-500 text-sm hover:underline">Edit</button>
                        <button class="text-red-500 text-sm hover:underline">Delete</button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">4</td>
                    <td class="py-3 font-medium">Sinta</td>
                    <td class="py-3">Marketing</td>
                    <td class="py-3">Content Specialist</td>
                    <td class="py-3 text-center space-x-3">
                        <button class="text-blue-500 text-sm hover:underline">Edit</button>
                        <button class="text-red-500 text-sm hover:underline">Delete</button>
                    </td>
                </tr>

            </tbody>
        </table>

        <x-modal id="modalKaryawan" title="Tambah Karyawan">

            <form class="space-y-5">

                <!-- ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        ID Karyawan
                    </label>

                    <input type="text"
                        placeholder="Contoh: KRY001"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md 
                       focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Nama Karyawan
                    </label>

                    <input type="text"
                        placeholder="Contoh: Budi Santoso"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md 
                       focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Divisi -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Divisi
                    </label>

                    <select
                        class="w-full px-3 py-2 border border-gray-300 rounded-md 
                       focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option>Pilih Divisi</option>
                        <option>IT</option>
                        <option>HRD</option>
                        <option>Finance</option>
                    </select>
                </div>

                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Jabatan
                    </label>

                    <input type="text"
                        placeholder="Contoh: Staff, Manager"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md 
                       focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Action -->
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button"
                        onclick="closeModal('modalKaryawan')"
                        class="px-4 py-2 text-gray-600 hover:text-black">
                        Batal
                    </button>

                    <button type="button"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Simpan
                    </button>
                </div>

            </form>

        </x-modal>

    </div>

</div>

@endsection