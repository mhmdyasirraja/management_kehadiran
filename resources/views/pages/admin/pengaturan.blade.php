@extends('layouts.app')

@section('content')
<div class="space-y-6">

    @include('components.header_card', [
        'title' => 'PENGATURAN',
        'subtitle' => now()->format('l, d F Y')
    ])

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Lokasi Kantor</h2>
            <button onclick="openModal('modalTambahLokasi')"
                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                + Tambah Lokasi
            </button>
        </div>

        <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm rounded-lg p-4 mb-6">
            <p>Karyawan hanya bisa check-in/check-out jika berada dalam radius salah satu lokasi kantor di bawah ini.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-600">
                <thead class="border-b text-gray-500 text-left">
                    <tr>
                        <th class="py-3">Nama Lokasi</th>
                        <th class="py-3">Latitude</th>
                        <th class="py-3">Longitude</th>
                        <th class="py-3">Radius (meter)</th>
                        <th class="py-3 text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($lokasis as $lokasi)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-medium">{{ $lokasi->nama_lokasi }}</td>
                        <td class="py-3">{{ $lokasi->latitude }}</td>
                        <td class="py-3">{{ $lokasi->longitude }}</td>
                        <td class="py-3">{{ $lokasi->radius }}</td>
                        <td class="py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('modalEditLokasi{{ $lokasi->id }}')"
                                    class="px-3 py-1 rounded bg-yellow-500 text-white text-xs font-semibold hover:bg-yellow-600 transition">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('admin.pengaturan.lokasi.destroy', $lokasi) }}"
                                    onsubmit="return confirm('Yakin hapus lokasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 rounded bg-red-500 text-white text-xs font-semibold hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-400">Belum ada lokasi kantor terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Jam Kerja --}}
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Jam Kerja</h2>

    <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm rounded-lg p-4 mb-6">
        <p>Karyawan hanya bisa check-in/check-out dalam rentang waktu yang ditentukan di bawah ini.</p>
    </div>

    <form method="POST" action="{{ route('admin.pengaturan.jamkerja.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <p class="text-sm font-medium text-gray-700 mb-2">Jam Check-In</p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Mulai</label>
                    <input type="time" name="checkin_mulai" required value="{{ $jamKerja['checkin_mulai'] }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Selesai</label>
                    <input type="time" name="checkin_selesai" required value="{{ $jamKerja['checkin_selesai'] }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                </div>
            </div>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-700 mb-2">Jam Check-Out</p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Mulai</label>
                    <input type="time" name="checkout_mulai" required value="{{ $jamKerja['checkout_mulai'] }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Selesai</label>
                    <input type="time" name="checkout_selesai" required value="{{ $jamKerja['checkout_selesai'] }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-4">
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                Simpan Jam Kerja
            </button>
        </div>
    </form>
</div>

    {{-- Modal Tambah Lokasi --}}
    <x-modal id="modalTambahLokasi" title="Tambah Lokasi Kantor">
        <form method="POST" action="{{ route('admin.pengaturan.lokasi.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs text-gray-500 mb-1">Nama Lokasi</label>
                <input type="text" name="nama_lokasi" required
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none"
                    placeholder="Contoh: Kantor Pusat">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Latitude</label>
                    <input type="number" step="any" name="latitude" required
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none"
                        placeholder="1.0500522">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Longitude</label>
                    <input type="number" step="any" name="longitude" required
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none"
                        placeholder="103.9898886">
                </div>
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Radius (meter)</label>
                <input type="number" name="radius" required value="100"
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                <p class="text-xs text-gray-400 mt-1">Jarak toleransi dari titik koordinat, dalam meter.</p>
            </div>

            <div class="border-t border-gray-100 pt-4 flex gap-3">
                <button type="submit"
                    class="w-full px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                    Simpan Lokasi
                </button>
            </div>
        </form>
    </x-modal>

    {{-- Modal Edit Lokasi (satu per baris) --}}
    @foreach($lokasis as $lokasi)
    <x-modal id="modalEditLokasi{{ $lokasi->id }}" title="Edit Lokasi Kantor">
        <form method="POST" action="{{ route('admin.pengaturan.lokasi.update', $lokasi) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs text-gray-500 mb-1">Nama Lokasi</label>
                <input type="text" name="nama_lokasi" required value="{{ $lokasi->nama_lokasi }}"
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Latitude</label>
                    <input type="number" step="any" name="latitude" required value="{{ $lokasi->latitude }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Longitude</label>
                    <input type="number" step="any" name="longitude" required value="{{ $lokasi->longitude }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Radius (meter)</label>
                <input type="number" name="radius" required value="{{ $lokasi->radius }}"
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
            </div>

            <div class="border-t border-gray-100 pt-4 flex gap-3">
                <button type="submit"
                    class="w-full px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </x-modal>
    @endforeach

</div>
@endsection