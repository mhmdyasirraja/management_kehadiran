@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
        'title' => 'SELAMAT DATANG, ADMIN',
        'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50/50 border border-blue-100 rounded-2xl p-5 flex items-start gap-4 shadow-sm">
        <div class="p-2 bg-blue-600 text-white rounded-xl shadow-sm hidden sm:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="text-sm text-blue-800">
            <p class="font-bold text-blue-900 mb-1">Catatan Kebijakan Perizinan:</p>
            <ul class="list-disc ml-4 space-y-1 text-blue-700/90 font-medium">
                <li><strong>Cuti:</strong> Wajib diajukan minimal 1 minggu sebelum hari pelaksanaan.</li>
                <li><strong>Sakit:</strong> Batas pelaporan maksimal 3 hari setelah hari pertama tidak masuk.</li>
            </ul>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        {{-- Filter & Search Header Area --}}
        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            {{-- Filter Tabs (Pills Layout) --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.approval.index', ['status' => 'pending', 'search' => $search]) }}"
                    class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200
                    {{ $filter === 'pending' ? 'bg-amber-100 text-amber-800 shadow-sm' : 'bg-white border border-gray-200 text-gray-500 hover:bg-gray-100' }}">
                    Pending
                </a>
                <a href="{{ route('admin.approval.index', ['status' => 'approved', 'search' => $search]) }}"
                    class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200
                    {{ $filter === 'approved' ? 'bg-emerald-100 text-emerald-800 shadow-sm' : 'bg-white border border-gray-200 text-gray-500 hover:bg-gray-100' }}">
                    Approved
                </a>
                <a href="{{ route('admin.approval.index', ['status' => 'rejected', 'search' => $search]) }}"
                    class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200
                    {{ $filter === 'rejected' ? 'bg-rose-100 text-rose-800 shadow-sm' : 'bg-white border border-gray-200 text-gray-500 hover:bg-gray-100' }}">
                    Rejected
                </a>
            </div>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('admin.approval.index') }}" class="flex items-center gap-2 w-full lg:w-auto">
                <input type="hidden" name="status" value="{{ $filter }}">
                <div class="relative w-full lg:w-64">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari nama karyawan..."
                        class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 shadow-sm transition-colors">
                    Cari
                </button>
                @if($search)
                <a href="{{ route('admin.approval.index', ['status' => $filter]) }}"
                    class="px-4 py-2.5 rounded-xl bg-gray-100 text-gray-600 text-sm font-semibold hover:bg-gray-200 transition-colors">
                    Reset
                </a>
                @endif
            </form>
        </div>

        {{-- Table Area --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-bold uppercase tracking-wider text-gray-500">
                        <th class="py-4 px-6 w-16 text-center">No</th>
                        <th class="py-4 px-6">Nama Karyawan</th>
                        <th class="py-4 px-6">Jenis Izin</th>
                        <th class="py-4 px-6">Rentang Tanggal</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($izin as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                        <!-- Nomor -->
                        <td class="py-4 px-6 text-center text-gray-400 font-mono">
                            {{ $loop->iteration }}
                        </td>
                        
                        <!-- Profil Karyawan -->
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold text-sm border border-blue-100/40 uppercase">
                                    {{ substr($item->karyawan->nama ?? 'U', 0, 2) }}
                                </div>
                                <span class="text-gray-900 font-semibold tracking-tight">
                                    {{ $item->karyawan->nama }}
                                </span>
                            </div>
                        </td>
                        
                        <!-- Jenis Izin -->
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700 capitalize">
                                {{ $item->jenis_izin }}
                            </span>
                        </td>
                        
                        <!-- Tanggal -->
                        <td class="py-4 px-6 whitespace-nowrap text-gray-600 font-medium">
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                            @if($item->tanggal_selesai && $item->tanggal_mulai != $item->tanggal_selesai)
                            <span class="text-gray-400 mx-1">–</span>
                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                            @endif
                        </td>
                        
                        <!-- Status Badge -->
                        <td class="py-4 px-6 text-center whitespace-nowrap">
                            @if($item->status === 'pending')
                                <span class="inline-flex items-center justify-center bg-amber-50 text-amber-700 border border-amber-200/60 px-3 py-1 rounded-xl text-xs font-bold min-w-[85px]">
                                    Pending
                                </span>
                            @elseif($item->status === 'approved')
                                <span class="inline-flex items-center justify-center bg-emerald-50 text-emerald-700 border border-emerald-200/60 px-3 py-1 rounded-xl text-xs font-bold min-w-[85px]">
                                    Approved
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center bg-rose-50 text-rose-700 border border-rose-200/60 px-3 py-1 rounded-xl text-xs font-bold min-w-[85px]">
                                    Rejected
                                </span>
                            @endif
                        </td>
                        
                        <!-- Tombol Detail -->
                        <td class="py-4 px-6 text-center whitespace-nowrap">
                            <button onclick="openModal('modalDetail{{ $item->id }}')"
                                class="inline-flex items-center justify-center px-4 py-1.5 rounded-xl bg-blue-50 text-blue-600 text-xs font-bold border border-blue-100 hover:bg-blue-600 hover:text-white hover:border-blue-600 shadow-sm transition-all duration-200">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <p class="text-gray-400 font-medium">Tidak ada pengajuan perizinan ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modals Detail --}}
    @foreach($izin as $item)
    <x-modal id="modalDetail{{ $item->id }}" title="Detail Dokumen Perizinan">
        <div class="space-y-5">

            {{-- Info Grid --}}
            <div class="grid grid-cols-2 gap-4 text-sm bg-gray-50 p-4 rounded-2xl border border-gray-100">
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Nama Karyawan</p>
                    <p class="font-bold text-gray-800">{{ $item->karyawan->nama }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Jenis Izin</p>
                    <p class="font-bold text-gray-800 capitalize">{{ $item->jenis_izin }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Tanggal Mulai</p>
                    <p class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Tanggal Selesai</p>
                    <p class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}</p>
                </div>
                <div class="col-span-2 border-t border-gray-200/60 pt-2.5">
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Keterangan / Alasan</p>
                    <p class="text-gray-700 leading-relaxed font-medium bg-white p-2.5 rounded-xl border border-gray-100 mt-1 shadow-inner-sm">{{ $item->keterangan }}</p>
                </div>
                <div class="col-span-2 pt-1.5">
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-1.5">Status Saat Ini</p>
                    @if($item->status === 'pending')
                    <span class="px-3 py-1 text-xs font-bold rounded-lg bg-amber-100 text-amber-800">Pending</span>
                    @elseif($item->status === 'approved')
                    <span class="px-3 py-1 text-xs font-bold rounded-lg bg-emerald-100 text-emerald-800">Approved</span>
                    @else
                    <span class="px-3 py-1 text-xs font-bold rounded-lg bg-rose-100 text-rose-800">Rejected</span>
                    @endif
                </div>
            </div>

            {{-- Surat Keterangan / Lampiran --}}
            <div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Berkas Lampiran Pendukung</p>
                @if($item->surat_keterangan)
                    @php
                        $ext = pathinfo($item->surat_keterangan, PATHINFO_EXTENSION);
                        $url = asset('storage/' . $item->surat_keterangan);
                    @endphp

                    <div class="border border-gray-100 bg-gray-50/50 p-3 rounded-2xl flex flex-col items-center">
                        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                        <img src="{{ $url }}" alt="Surat Keterangan"
                            class="w-full rounded-xl border border-gray-200 max-h-56 object-contain shadow-sm bg-white mb-3">
                        @endif

                        <a href="{{ $url }}" target="_blank"
                            class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 bg-blue-50 border border-blue-100 px-4 py-2 rounded-xl hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            {{ in_array(strtolower($ext), ['pdf']) ? 'Buka Dokumen PDF' : 'Lihat Lampiran Ukuran Penuh' }}
                        </a>
                    </div>
                @else
                    <div class="text-xs text-gray-400 italic bg-gray-50 border border-dashed border-gray-200 p-4 rounded-xl text-center">
                        Tidak ada berkas/surat keterangan yang dilampirkan.
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            @if($item->status === 'pending')
            <div class="border-t border-gray-100 pt-4 flex gap-3">
                <form method="POST" action="{{ route('admin.approval.approve', $item) }}" class="w-1/2">
                    @csrf
                    @php echo method_field('PATCH'); @endphp
                    <button type="submit"
                        class="w-full py-2.5 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 shadow-sm transition-colors">
                        Setujui Permohonan
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.approval.reject', $item) }}" class="w-1/2">
                    @csrf
                    @php echo method_field('PATCH'); @endphp
                    <button type="submit"
                        class="w-full py-2.5 bg-rose-600 text-white text-sm font-bold rounded-xl hover:bg-rose-700 shadow-sm transition-colors">
                        Tolak Permohonan
                    </button>
                </form>
            </div>
            @else
            <div class="border-t border-gray-100 pt-4">
                <button type="button" onclick="closeModal('modalDetail{{ $item->id }}')"
                    class="w-full py-2.5 border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                    Kembali
                </button>
            </div>
            @endif

        </div>
    </x-modal>
    @endforeach

</div>
@endsection