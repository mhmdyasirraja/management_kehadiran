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
                class="bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah Karyawan
            </button>
        </div>

        <div class="border-b mb-4"></div>
        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('karyawan.index') }}" class="flex gap-3 mb-4">
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
                class="px-4 py-2 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                Reset
            </a>
            @endif
        </form>
        <table class="w-full table-fixed text-sm text-gray-600">
            <thead>
                <tr class="text-gray-500 text-left">
                    <th class="py-3 font-medium w-28">NIP</th>
                    <th class="py-3 font-medium w-40">Nama</th>
                    <th class="py-3 font-medium w-32">Divisi</th>
                    <th class="py-3 font-medium">Email</th>
                    <th class="py-3 font-medium w-24 text-center">Status</th>
                    <th class="py-3 font-medium w-36 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($karyawan as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">{{ $item->nip }}</td>
                    <td class="py-3 font-medium capitalize">{{ $item->nama }}</td>
                    <td class="py-3">
                        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">
                            {{ $item->divisi->nama ?? '-' }}
                        </span>
                    </td>
                    <td class="py-3">{{ $item->user->email ?? '-' }}</td>
                    <td class="py-3 text-center">
                        <form action="{{ route('karyawan.updateStatus', $item->id) }}" method="POST" class="flex justify-center">
                            @csrf
                            <button type="submit"
                                class="relative inline-flex items-center w-11 h-6 rounded-full transition-colors duration-300
                                        {{ $item->status === 'aktif' ? 'bg-green-500' : 'bg-gray-300' }}">
                                <span class="inline-block w-4 h-4 bg-white rounded-full shadow transform transition-transform duration-300
                                        {{ $item->status === 'aktif' ? 'translate-x-6' : 'translate-x-1' }}">
                                </span>
                            </button>
                        </form>
                    </td>
                    <td class="py-3">
                        <div class="flex justify-center gap-2">
                            <button onclick="openModal('modalEdit{{ $item->id }}')"
                                class="px-3 py-1 rounded bg-yellow-400 text-white text-xs font-semibold hover:bg-yellow-500">
                                Edit
                            </button>
                            <button onclick="openModal('modalHapus{{ $item->id }}')"
                                class="px-3 py-1 rounded bg-red-500 text-white text-xs font-semibold hover:bg-red-600">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-400">
                        Data karyawan belum tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

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