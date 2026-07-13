@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    @include('components.header_card', [
    'title' => 'Riwayat Absensi',
    'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Filter (UI saja; belum ada request query) --}}
    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div class="flex flex-wrap gap-4 items-center">
                <!-- Dari -->
                <div>
                    <input type="date"
                        class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm w-full sm:w-48">
                </div>

                <!-- Sampai -->
                <div>
                    <input type="date"
                        class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm w-full sm:w-48">
                </div>

                <!-- Status -->
                <div>
                    <select
                        class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm w-full sm:w-48">

                        <option value="">Semua Status</option>
                        <option value="hadir">Hadir</option>
                        <option value="terlambat">Terlambat</option>
                        <option value="izin">Izin</option>
                        <option value="Tidak Hadir">Tidak Hadir</option>

                    </select>
                </div>
            </div>

            <div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 w-full sm:w-auto">
                    Filter
                </button>
            </div>

        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm overflow-hidden">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <h5 class="text-lg font-semibold text-gray-800">Riwayat Absensi</h5>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-500">
                    <tr class="text-left">
                        <th class="px-3 sm:px-6 py-3 font-semibold">No</th>
                        <th class="px-3 sm:px-6 py-3 font-semibold">Tanggal</th>
                        <th class="px-3 sm:px-6 py-3 font-semibold">Jam Masuk</th>
                        <th class="px-3 sm:px-6 py-3 font-semibold">Jam Keluar</th>
                        <th class="px-3 sm:px-6 py-3 font-semibold">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat as $index => $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-3 sm:px-6 py-3 font-medium">{{ $index + 1 }}</td>

                            <td class="px-3 sm:px-6 py-3">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </td>

                            <td class="px-3 sm:px-6 py-3">{{ $item->jam_masuk ?? '—' }}</td>

                            <td class="px-3 sm:px-6 py-3">{{ $item->jam_keluar ?? '—' }}</td>

                            <td class="px-3 sm:px-6 py-3">
                                @if($item->status == 'Hadir')
                                    <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-3 py-1 text-xs font-medium">
                                        ✔ Hadir
                                    </span>
                                @elseif($item->status == 'Izin')
                                    <span class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-xs font-medium">
                                        📝 Izin
                                    </span>
                                @elseif($item->status == 'Tidak Hadir')
                                    <span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-3 py-1 text-xs font-medium">
                                        ✖ Tidak Hadir
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-3 py-1 text-xs font-medium">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 sm:px-6 py-10 text-center text-gray-500">
                                Belum ada riwayat absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection

