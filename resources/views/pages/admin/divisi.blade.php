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
        {{-- Top Action --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold text-gray-700">Management Divisi</h2>

            <div class="flex items-center gap-3">
                <form action="{{ route('divisi.index') }}" method="GET" class="flex items-center">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari nama divisi..."
                        class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @if($search ?? false)
                    <a href="{{ route('divisi.index') }}" class="ml-2 text-sm text-gray-400 hover:text-gray-600">
                        Reset
                    </a>
                    @endif
                </form>

                <button onclick="openModal('modalDivisi')" class="bg-blue-600 text-white px-4 py-2 rounded">
                    + Tambah Divisi
                </button>
            </div>
        </div>



        {{-- Table --}}
        {{-- Table --}}
<div class="overflow-x-auto rounded-xl border border-gray-100">

    <table class="min-w-full">

        <thead class="bg-gray-50">
            <tr class="text-xs uppercase tracking-wider text-gray-500">

                <th class="px-6 py-4 text-left">
                    No
                </th>

                <th class="px-6 py-4 text-left">
                    Divisi
                </th>

                <th class="px-6 py-4 text-center">
                    Jumlah Karyawan
                </th>

                <th class="px-6 py-4 text-center">
                    Dibuat
                </th>

                <th class="px-6 py-4 text-center">
                    Aksi
                </th>

            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse($divisi as $index => $item)

            <tr class="hover:bg-slate-50 transition duration-200">

                <td class="px-6 py-4 text-gray-400 font-medium">
                    {{ $index + 1 }}
                </td>

                <td class="px-6 py-4">

                    <div class="flex items-center gap-3">

                        {{-- Icon Divisi --}}
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-blue-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 11H5m14-6H5m14 12H5m14 6H5"/>

                            </svg>

                        </div>

                        <div>

                            <p class="font-semibold text-gray-800">
                                {{ $item->nama }}
                            </p>

                            <p class="text-xs text-gray-400">
                                Divisi
                            </p>

                        </div>

                    </div>

                </td>

                <td class="px-6 py-4 text-center">

                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">

                        {{ $item->karyawan_count ?? 0 }}

                        Karyawan

                    </span>

                </td>

                <td class="px-6 py-4 text-center text-gray-500">

                    {{ $item->created_at->format('d M Y') }}

                </td>

                <td class="px-6 py-4">

                    <div class="flex justify-center gap-2">

                        <button
                            onclick="openModal('modalEditDivisi{{ $index }}')"
                            class="px-4 py-2 rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition text-sm font-medium">

                            Edit

                        </button>

                        <button
                            onclick="openModal('modalDeleteDivisi{{ $index }}')"
                            class="px-4 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition text-sm font-medium">

                            Hapus

                        </button>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="5" class="py-12 text-center">

                    <div class="flex flex-col items-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-12 h-12 text-gray-300 mb-3"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M9 17v-2a4 4 0 014-4h4"/>

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M3 7h18M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>

                        </svg>

                        <p class="text-gray-400">

                            Data divisi belum tersedia.

                        </p>

                    </div>

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

        {{-- Modal Tambah --}}
        <x-modal id="modalDivisi" title="Tambah Divisi">
            <form action="{{ route('divisi.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Divisi</label>
                    <input type="text" name="nama" placeholder="Contoh: IT, HRD, Finance"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>
                <p class="text-xs text-gray-400">Nomor divisi dibuat otomatis oleh sistem.</p>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('modalDivisi')"
                        class="px-4 py-2 text-gray-600 hover:text-black">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Edit & Delete --}}
        @foreach($divisi as $index => $item)
        <x-modal id="modalEditDivisi{{ $index }}" title="Edit Divisi">
            <form action="{{ route('divisi.update', $item->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Divisi</label>
                    <input type="text" name="nama" value="{{ $item->nama }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ $item->deskripsi }}</textarea>
                </div>
                <div class="flex flex-row gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalEditDivisi{{ $index }}')"
                        class="px-4 py-2 text-gray-600 hover:text-black w-1/2 border border-gray-200 rounded">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-500 text-white rounded w-1/2 hover:bg-yellow-600">Simpan</button>
                </div>
            </form>
        </x-modal>

        <x-modal id="modalDeleteDivisi{{ $index }}" title="Hapus Divisi">
            <form action="{{ route('divisi.destroy', $item->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('DELETE')
                <p>Apakah Anda yakin ingin menghapus divisi <span class="font-semibold">{{ $item->nama }}</span>?</p>
                <div class="flex flex-row gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalDeleteDivisi{{ $index }}')"
                        class="px-4 py-2 text-gray-600 hover:text-black w-1/2 border border-gray-200 rounded">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded w-1/2 hover:bg-red-700">Hapus</button>
                </div>
            </form>
        </x-modal>
        @endforeach

    </div>
</div>
@endsection