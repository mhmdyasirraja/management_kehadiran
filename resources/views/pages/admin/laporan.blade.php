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
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Riwayat Kehadiran Karyawan</h2>
                <p class="text-sm text-gray-500 mt-0.5">Menampilkan seluruh data absensi berdasarkan filter terpilih.</p>
            </div>
            <div class="text-sm font-medium text-gray-500 bg-gray-50 px-4 py-2 rounded-xl self-start sm:self-center">
                Total: <span class="text-blue-600 font-bold">{{ $laporan->total() ?? 0 }}</span> Data
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-bold uppercase tracking-wider text-gray-500">
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Karyawan</th>
                        <th class="py-4 px-6">Jam Masuk</th>
                        <th class="py-4 px-6">Jam Keluar</th>
                        <th class="py-4 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($laporan as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                        <!-- Tanggal -->
                        <td class="py-4 px-6 text-gray-600 font-medium whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        
                        <!-- Profil Karyawan (Stacked NIP & Nama) -->
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-semibold text-sm border border-blue-100/50 uppercase">
                                    {{ substr($item->karyawan->nama ?? 'K', 0, 2) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-gray-900 font-semibold hover:text-blue-600 transition-colors">
                                        {{ $item->karyawan->nama ?? '-' }}
                                    </span>
                                    <span class="text-xs text-gray-400 font-mono">
                                        {{ $item->karyawan->nip ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Jam Masuk -->
                        <td class="py-4 px-6 whitespace-nowrap">
                            @if($item->jam_masuk)
                                <span class="text-gray-700 font-medium bg-gray-100/80 px-2.5 py-1 rounded-lg text-xs font-mono">
                                    {{ \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') }}
                                </span>
                            @else
                                <span class="text-gray-400 font-mono">-</span>
                            @endif
                        </td>
                        
                        <!-- Jam Keluar -->
                        <td class="py-4 px-6 whitespace-nowrap">
                            @if($item->jam_keluar)
                                <span class="text-gray-700 font-medium bg-gray-100/80 px-2.5 py-1 rounded-lg text-xs font-mono">
                                    {{ \Carbon\Carbon::parse($item->jam_keluar)->format('H:i') }}
                                </span>
                            @else
                                <span class="text-gray-400 font-mono">-</span>
                            @endif
                        </td>
                        
                        <!-- Status Badge (Case-Insensitive Handling) -->
                        <td class="py-4 px-6 text-center whitespace-nowrap">
                            @php 
                                $statusClean = strtolower($item->status ?? ''); 
                            @endphp

                            @if($statusClean == 'hadir')
                                <span class="inline-flex items-center justify-center bg-emerald-50 text-emerald-700 border border-emerald-200/60 px-3 py-1 rounded-xl text-xs font-semibold min-w-[70px]">
                                    Hadir
                                </span>
                            @elseif($statusClean == 'izin' || $statusClean == 'cuti')
                                <span class="inline-flex items-center justify-center bg-blue-50 text-blue-700 border border-blue-200/60 px-3 py-1 rounded-xl text-xs font-semibold min-w-[70px]">
                                    {{ ucfirst($item->status) }}
                                </span>
                            @elseif($statusClean == 'sakit')
                                <span class="inline-flex items-center justify-center bg-amber-50 text-amber-700 border border-amber-200/60 px-3 py-1 rounded-xl text-xs font-semibold min-w-[70px]">
                                    Sakit
                                </span>
                            |@elseif($statusClean == 'alpha')
                                <span class="inline-flex items-center justify-center bg-rose-50 text-rose-700 border border-rose-200/60 px-3 py-1 rounded-xl text-xs font-semibold min-w-[70px]">
                                    Alpha
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center bg-gray-50 text-gray-600 border border-gray-200 px-3 py-1 rounded-xl text-xs font-semibold min-w-[70px]">
                                    {{ ucfirst($item->status ?? '-') }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <span class="text-3xl text-gray-300">📋</span>
                                <p class="text-gray-400 font-medium">Belum ada data laporan yang sesuai</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($laporan->hasPages())
        <div class="p-6 bg-gray-50/50 border-t border-gray-100">
            {{ $laporan->links() }}
        </div>
        @endif
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#filter-karyawan', {
            placeholder: 'Cari nama karyawan...',
            allowEmptyOption: true,
            create: false,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results">Tidak ditemukan karyawan bernama "' + escape(data.input) + '"</div>';
                }
            }
        });
    });
</script>

@endsection