@extends('layouts.app')

@section('content')
<div class="space-y-6">

    @include('components.header_card', [
        'title' => 'SELAMAT DATANG, ADMIN',
        'subtitle' => now()->format('l, d F Y')
    ])

    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Management Karyawan</h2>
            <button onclick="openModal('modalKaryawan')"
                class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
                + Tambah Karyawan
            </button>
        </div>

        <div class="border-b mb-4"></div>

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('karyawan.index') }}" class="flex gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama atau NIP..."
                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <select name="divisi_id"
                class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Semua Divisi</option>
                @foreach($divisi as $d)
                <option value="{{ $d->id }}" {{ request('divisi_id') == $d->id ? 'selected' : '' }}>
                    {{ $d->nama }}
                </option>
                @endforeach
            </select>

            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                Cari
            </button>

            @if(request('search') || request('divisi_id'))
            <a href="{{ route('karyawan.index') }}"
                class="px-4 py-2 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200 flex items-center">
                Reset
            </a>
            @endif
        </form>

        {{-- Table (Disamakan dengan Management Divisi) --}}
        <div class="overflow-x-auto rounded-xl border border-gray-100">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr class="text-xs uppercase tracking-wider text-gray-500">
                        <th class="px-6 py-4 text-left">NIP</th>
                        <th class="px-6 py-4 text-left">Nama</th>
                        <th class="px-6 py-4 text-left">Divisi</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($karyawan as $item)
                    <tr class="hover:bg-slate-50 transition duration-200">
                        
                        {{-- NIP --}}
                        <td class="px-6 py-4 text-gray-500 font-medium">
                            {{ $item->nip }}
                        </td>

                        {{-- Nama --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                {{-- Initial Avatar --}}
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 capitalize">{{ $item->nama }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Divisi --}}
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold">
                                {{ $item->divisi->nama ?? '-' }}
                            </span>
                        </td>

                        {{-- Email --}}
                        <td class="px-6 py-4 text-gray-600 text-sm">
                            {{ $item->user->email ?? '-' }}
                        </td>

                        {{-- Status (Toggle Button) --}}
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('karyawan.updateStatus', $item->id) }}" method="POST" class="flex justify-center">
                                @csrf
                                <button type="submit"
                                    class="relative inline-flex items-center w-11 h-6 rounded-full transition-colors duration-300 focus:outline-none {{ $item->status === 'aktif' ? 'bg-green-500' : 'bg-gray-300' }}">
                                    <span class="inline-block w-4 h-4 bg-white rounded-full shadow transform transition-transform duration-300 {{ $item->status === 'aktif' ? 'translate-x-6' : 'translate-x-1' }}">
                                    </span>
                                </button>
                            </form>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('modalEdit{{ $item->id }}')"
                                    class="px-4 py-2 rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition text-sm font-medium">
                                    Edit
                                </button>
                                <button onclick="openModal('modalHapus{{ $item->id }}')"
                                    class="px-4 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition text-sm font-medium">
                                    Hapus
                                </button>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-gray-400">Data karyawan belum tersedia.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modals (Tambah, Edit, Hapus) tetap di bawah sini... --}}

        <!-- tambah -->
        <x-modal id="modalKaryawan" title="Tambah Karyawan">
            <form action="{{ route('karyawan.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Karyawan</label>
                    <input type="text" name="nama" placeholder="Contoh: Budi Santoso" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Divisi</label>
                    <select name="divisi_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Pilih Divisi</option>
                        @foreach($divisi as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" placeholder="Contoh: budi@email.com" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('modalKaryawan')"
                        class="px-4 py-2 text-gray-600 hover:text-black">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </x-modal>

        @foreach($karyawan as $item)

        <!-- edit -->
        <x-modal id="modalEdit{{ $item->id }}" title="Edit Karyawan">
            <form action="{{ route('karyawan.update', $item->id) }}" method="POST" class="space-y-5" autocomplete="off">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Karyawan</label>
                    <input type="text" name="nama" value="{{ $item->nama }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Divisi</label>
                    <select name="divisi_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        <option value="">Pilih Divisi</option>
                        @foreach($divisi as $d)
                        <option value="{{ $d->id }}" {{ $item->divisi_id == $d->id ? 'selected' : '' }}>
                            {{ $d->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ $item->user->email ?? '' }}" autocomplete="new-email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Password Baru <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter" autocomplete="new-password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalEdit{{ $item->id }}')"
                        class="px-4 py-2 text-gray-600 border border-gray-200 rounded w-1/2">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-500 text-white rounded w-1/2 hover:bg-yellow-600">Simpan</button>
                </div>
            </form>
        </x-modal>

        <!-- hapus -->
        <x-modal id="modalHapus{{ $item->id }}" title="Hapus Karyawan">
            <form action="{{ route('karyawan.destroy', $item->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('DELETE')
                <p class="text-gray-600">Apakah Anda yakin ingin menghapus karyawan
                    <span class="font-semibold">{{ $item->nama }}</span>?
                </p>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalHapus{{ $item->id }}')"
                        class="px-4 py-2 text-gray-600 border border-gray-200 rounded w-1/2">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded w-1/2 hover:bg-red-700">Hapus</button>
                </div>
            </form>
        </x-modal>

        @endforeach

    </div>
</div>
@endsection