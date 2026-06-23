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

        {{-- Flash Message --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-4 mb-4">
            {{ session('success') }}
        </div>
        @endif

        {{-- Info --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm rounded-lg p-4 mb-6">
            <p class="font-medium mb-2">Catatan Perizinan:</p>
            <ul class="list-disc ml-5 space-y-1">
                <li><strong>Cuti:</strong> diajukan minimal 1 minggu sebelum hari H.</li>
                <li><strong>Sakit:</strong> maksimal 3 hari setelah hari H.</li>
            </ul>
        </div>

        {{-- Filter & Search --}}
        <div class="flex flex-col md:flex-row md:items-center gap-3 mb-4">

            {{-- Filter Tabs --}}
            <div class="flex gap-2">
                <a href="{{ route('admin.approval.index', ['status' => 'pending', 'search' => $search]) }}"
                    class="px-4 py-1.5 rounded-lg text-sm font-medium transition
            {{ $filter === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                    Pending
                </a>
                <a href="{{ route('admin.approval.index', ['status' => 'approved', 'search' => $search]) }}"
                    class="px-4 py-1.5 rounded-lg text-sm font-medium transition
            {{ $filter === 'approved' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                    Approved
                </a>
                <a href="{{ route('admin.approval.index', ['status' => 'rejected', 'search' => $search]) }}"
                    class="px-4 py-1.5 rounded-lg text-sm font-medium transition
            {{ $filter === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                    Rejected
                </a>
            </div>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('admin.approval.index') }}" class="flex gap-2 md:ml-auto">
                <input type="hidden" name="status" value="{{ $filter }}">
                <input type="text" name="search" value="{{ $search }}"
                    placeholder="Cari nama karyawan"
                    class="px-4 py-1.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 w-56">
                <button type="submit"
                    class="px-4 py-1.5 rounded-lg bg-blue-500 text-white text-sm hover:bg-blue-600 transition">
                    Cari
                </button>
                @if($search)
                <a href="{{ route('admin.approval.index', ['status' => $filter]) }}"
                    class="px-4 py-1.5 rounded-lg bg-gray-100 text-gray-500 text-sm hover:bg-gray-200 transition">
                    Reset
                </a>
                @endif
            </form>

        </div>


        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-600">
                <thead class="border-b text-gray-500 text-left">
                    <tr>
                        <th class="py-3 w-16">No</th>
                        <th class="py-3">Nama</th>
                        <th class="py-3">Jenis</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($izin as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3">{{ $loop->iteration }}</td>
                        <td class="py-3 font-medium">{{ $item->karyawan->nama }}</td>
                        <td class="py-3 capitalize">{{ $item->jenis_izin }}</td>
                        <td class="py-3">
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                            @if($item->tanggal_selesai && $item->tanggal_mulai != $item->tanggal_selesai)
                            – {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                            @endif
                        </td>
                        <td class="py-3">
                            @if($item->status === 'pending')
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-600">Pending</span>
                            @elseif($item->status === 'approved')
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-600">Approved</span>
                            @else
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-600">Rejected</span>
                            @endif
                        </td>
                        <td class="py-3 text-center">
                            {{-- Semua status bisa lihat detail --}}
                            <div class="flex flex-row justify-center items-center gap-2">
                                <button onclick="openModal('modalDetail{{ $item->id }}')"
                                    class="inline-flex px-3 py-1 rounded bg-blue-500 text-white text-xs font-semibold hover:bg-blue-600 transition">
                                    Detail
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-400">Belum ada data perizinan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modals Detail --}}
        @foreach($izin as $item)
        <x-modal id="modalDetail{{ $item->id }}" title="Detail Perizinan">
            <div class="space-y-4">

                {{-- Info Karyawan --}}
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Nama</p>
                        <p class="font-medium text-gray-800">{{ $item->karyawan->nama }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Jenis Izin</p>
                        <p class="font-medium text-gray-800 capitalize">{{ $item->jenis_izin }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Tanggal Mulai</p>
                        <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Tanggal Selesai</p>
                        <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-400 text-xs mb-1">Keterangan</p>
                        <p class="font-medium text-gray-800">{{ $item->keterangan }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-400 text-xs mb-1">Status</p>
                        @if($item->status === 'pending')
                        <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-600">Pending</span>
                        @elseif($item->status === 'approved')
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-600">Approved</span>
                        @else
                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-600">Rejected</span>
                        @endif
                    </div>
                </div>

                {{-- Surat Keterangan --}}
                @if($item->surat_keterangan)
                <div>
                    <p class="text-gray-400 text-xs mb-2">Surat Keterangan</p>
                    @php
                    $ext = pathinfo($item->surat_keterangan, PATHINFO_EXTENSION);
                    $url = asset('storage/' . $item->surat_keterangan);
                    @endphp

                    @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                    <img src="{{ $url }}" alt="Surat Keterangan"
                        class="w-full rounded-lg border border-gray-200 max-h-48 object-contain">
                    @endif

                    <a href="{{ $url }}" target="_blank"
                        class="mt-2 inline-flex items-center gap-1.5 text-xs text-blue-600 hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h4a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        {{ $ext === 'pdf' ? 'Lihat PDF' : 'Lihat Gambar' }}
                    </a>
                </div>
                @else
                <div class="text-xs text-gray-400 italic">Tidak ada surat keterangan dilampirkan.</div>
                @endif

                {{-- Tombol Aksi (hanya pending) --}}
                @if($item->status === 'pending')
                <div class="border-t border-gray-100 pt-4 flex flex-row gap-3">
                    <form method="POST" action="{{ route('admin.approval.approve', $item) }}" class="w-1/2">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                            Setujui
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.approval.reject', $item) }}" class="w-1/2">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                            Tolak
                        </button>
                    </form>
                </div>
                @else
                <div class="border-t border-gray-100 pt-4">
                    <button type="button" onclick="closeModal('modalDetail{{ $item->id }}')"
                        class="w-full px-4 py-2 border border-gray-200 text-gray-600 text-sm rounded hover:bg-gray-50">
                        Tutup
                    </button>
                </div>
                @endif

            </div>
        </x-modal>
        @endforeach

    </div>

</div>

@endsection