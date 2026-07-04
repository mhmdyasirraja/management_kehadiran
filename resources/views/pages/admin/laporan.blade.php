@extends('layouts.app')

@section('content')
<div class="p-6 md:p-10 space-y-6">

    {{-- Header Card --}}
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <h1 class="text-3xl font-bold text-gray-800">Laporan Absensi</h1>
        <p class="text-gray-400 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>

   {{-- Filter Card --}}
<div class="bg-white rounded-2xl shadow-sm p-8">
    <form method="GET" action="{{ route('admin.laporan') }}"
        class="flex flex-col md:flex-row md:flex-wrap gap-4 items-stretch md:items-center">

        <select name="nama"
            class="w-full md:w-auto md:min-w-[220px] md:flex-1 rounded-xl border border-gray-200 px-4 py-3 text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            <option value="">Semua Karyawan</option>
            @foreach($karyawans as $k)
                <option value="{{ $k->nama }}" {{ request('nama') == $k->nama ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>

        <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
            class="w-full md:w-auto md:min-w-[170px] rounded-xl border border-gray-200 px-4 py-3 text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

        <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
            class="w-full md:w-auto md:min-w-[170px] rounded-xl border border-gray-200 px-4 py-3 text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

        <select name="status"
            class="w-full md:w-auto md:min-w-[170px] rounded-xl border border-gray-200 px-4 py-3 text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            <option value="">Semua Status</option>
            <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
            <option value="cuti" {{ request('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
            <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
            <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
        </select>

        <div class="flex gap-2 w-full md:w-auto">
            <button type="submit"
                class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition whitespace-nowrap">
                Filter
            </button>
            <a href="{{ route('admin.laporan') }}"
                class="flex-1 md:flex-none text-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold px-6 py-3 rounded-xl transition whitespace-nowrap">
                Reset
            </a>
        </div>
    </form>
</div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <h2 class="text-xl font-bold text-gray-800 pb-4 border-b border-gray-200 mb-6">
            Riwayat Kehadiran Karyawan
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-gray-500 text-sm">
                        <th class="pb-4 font-semibold">Nama Karyawan</th>
                        <th class="pb-4 font-semibold">Tanggal</th>
                        <th class="pb-4 font-semibold">Jam Masuk</th>
                        <th class="pb-4 font-semibold">Jam Keluar</th>
                        <th class="pb-4 font-semibold">Status</th>
                    </tr>
                </thead>
                
<tbody>
    @forelse($laporan as $item)
        <tr class="border-t border-gray-100">
            <td class="py-4 text-gray-700 font-medium">
                {{ $item->nama_karyawan }}
            </td>
            <td class="py-4 text-gray-700">
                {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}
            </td>
            <td class="py-4 text-gray-700">
                {{ $item->jam_masuk ?? '-' }}
            </td>
            <td class="py-4 text-gray-700">
                {{ $item->jam_keluar ?? '-' }}
            </td>
            <td class="py-4">
                @php
                    $badgeColor = match($item->status) {
                        'hadir' => 'bg-green-100 text-green-700',
                        'cuti' => 'bg-yellow-100 text-yellow-700',
                        'sakit' => 'bg-blue-100 text-blue-700',
                        'alpha' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <span class="px-4 py-1.5 rounded-full text-sm font-medium {{ $badgeColor }}">
                    {{ ucfirst($item->status) }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="py-10 text-center text-gray-400">
                Belum ada data laporan
            </td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($laporan->hasPages())
            <div class="mt-6 pt-6 border-t border-gray-100">
                {{ $laporan->links() }}
            </div>
        @endif
    </div>

</div>
@endsection