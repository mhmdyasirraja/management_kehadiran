@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header Card --}}
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <h1 class="text-3xl font-bold text-gray-800">Laporan Absensi</h1>
        <p class="text-gray-400 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>

    {{-- Export File --}}
    <div class="flex justify-end gap-2 mb-4">
        <a href="{{ route('admin.laporan.export-pdf', request()->query()) }}"
            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm flex items-center gap-2">
            Export PDF
        </a>
        <a href="{{ route('admin.laporan.export-excel', request()->query()) }}"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm flex items-center gap-2">
            Export Excel
        </a>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <form method="GET" action="{{ route('admin.laporan') }}"
            class="flex flex-col md:flex-row md:flex-wrap gap-4 items-stretch md:items-center">

            {{-- Filter Bulan --}}
            <select name="bulan"
                class="w-full md:w-auto md:min-w-[160px] rounded-xl border border-gray-200 px-4 py-3 text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Semua Bulan</option>
                @php
                    $namaBulan = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                    ];
                @endphp
                @foreach($namaBulan as $angka => $nama)
                    <option value="{{ $angka }}" {{ request('bulan') == $angka ? 'selected' : '' }}>
                        {{ $nama }}
                    </option>
                @endforeach
            </select>

            {{-- Filter Tahun --}}
            <select name="tahun"
                class="w-full md:w-auto md:min-w-[140px] rounded-xl border border-gray-200 px-4 py-3 text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Semua Tahun</option>
                @for($tahun = now()->year; $tahun >= now()->year - 5; $tahun--)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endfor
            </select>

            {{-- Filter Karyawan --}}
            <select name="karyawan_id" id="filter-karyawan"
            class="w-full md:w-auto md:min-w-[220px] md:flex-1 rounded-xl border border-gray-200 px-4 py-3 text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            <option value="">Semua Karyawan</option>
            @foreach($karyawans as $k)
            <option value="{{ $k->id }}" {{ request('karyawan_id') == $k->id ? 'selected' : '' }}>
            {{ $k->nama }}
        </option>
    @endforeach
</select>

            {{-- Filter Divisi --}}
            <select name="divisi_id"
                class="w-full md:w-auto md:min-w-[180px] rounded-xl border border-gray-200 px-4 py-3 text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Semua Divisi</option>
                @foreach($divisis as $d)
                    <option value="{{ $d->id }}" {{ request('divisi_id') == $d->id ? 'selected' : '' }}>
                        {{ $d->nama }}
                    </option>
                @endforeach
            </select>

            {{-- Filter Status --}}
            <select name="status"
                class="w-full md:w-auto md:min-w-[150px] rounded-xl border border-gray-200 px-4 py-3 text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
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
                        <th class="pb-4 font-semibold">Tanggal</th>
                        <th class="pb-4 font-semibold">NIP</th>
                        <th class="pb-4 font-semibold">Nama Karyawan</th>
                        <th class="pb-4 font-semibold">Jam Masuk</th>
                        <th class="pb-4 font-semibold">Jam Keluar</th>
                        <th class="pb-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                    <tr class="border-t border-gray-100">
                        <td class="py-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}
                        </td>
                        <td class="py-4 text-gray-700">
                            {{ $item->karyawan->nip ?? '-' }}
                        </td>
                        <td class="py-4 text-gray-700 font-medium">
                            {{ $item->karyawan->nama ?? '-' }}
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
                        <td colspan="6" class="py-10 text-center text-gray-400">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    new TomSelect('#filter-karyawan', {
        placeholder: 'Cari nama karyawan...',
        allowEmptyOption: true,
        create: false,
        sortField: {
            field: 'text',
            direction: 'asc'
        },
        render: {
            no_results: function (data, escape) {
                return '<div class="no-results">Tidak ditemukan karyawan bernama "' + escape(data.input) + '"</div>';
            }
        }
    });
});
</script>

@endsection