@extends('layouts.main')

@section('title', 'Profil Saya')

@section('content')
<div class="pt-28 pb-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4">

        <!-- ===== PROFIL USER ===== -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Profil Saya</h2>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-1">Nama</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block mb-1">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block mb-1">Foto Profil</label>
                    <input type="file" name="foto" class="w-full">
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Simpan Profil</button>
                </div>
            </form>
        </div>

        <!-- ===== ALAMAT USER ===== -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Alamat Saya</h2>
                <button onclick="document.getElementById('modalTambahAlamat').classList.remove('hidden')" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Tambah Alamat</button>
            </div>

            <div class="space-y-4">
                @foreach($user->alamats as $alamat)
                <div class="border p-4 rounded flex justify-between items-start">
                    <div>
                        <p><strong>{{ $alamat->label }}</strong> {{ $alamat->is_default ? '(Default)' : '' }}</p>
                        <p>{{ $alamat->nama_penerima }} - {{ $alamat->telepon_penerima }}</p>
                        <p>{{ $alamat->alamat_lengkap }}, {{ $alamat->kota }} {{ $alamat->kode_pos }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="document.getElementById('modalEditAlamat{{ $alamat->id }}').classList.remove('hidden')" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>
                        <button onclick="document.getElementById('modalHapusAlamat{{ $alamat->id }}').classList.remove('hidden')" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            Hapus
                        </button>
                    </div>
                </div>

                <!-- MODAL EDIT ALAMAT -->
                <div id="modalEditAlamat{{ $alamat->id }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden z-50">
                    <div class="bg-white rounded-lg p-6 w-full max-w-lg relative">
                        <button onclick="document.getElementById('modalEditAlamat{{ $alamat->id }}').classList.add('hidden')" class="absolute top-3 right-3 text-gray-600">&times;</button>
                        <h3 class="text-lg font-bold mb-4">Edit Alamat</h3>

                        <form method="POST" action="{{ route('profile.alamatUpdate', $alamat) }}">
                            @csrf
                            @method('PUT')
                            <div class="space-y-3">
                                <input type="text" name="label" value="{{ $alamat->label }}" class="w-full border p-2 rounded" required>
                                <input type="text" name="nama_penerima" value="{{ $alamat->nama_penerima }}" class="w-full border p-2 rounded" required>
                                <input type="text" name="telepon_penerima" value="{{ $alamat->telepon_penerima }}" class="w-full border p-2 rounded" required>
                                <textarea name="alamat_lengkap" class="w-full border p-2 rounded" required>{{ $alamat->alamat_lengkap }}</textarea>
                                <input type="text" name="kota" value="{{ $alamat->kota }}" class="w-full border p-2 rounded" required>
                                <input type="text" name="kode_pos" value="{{ $alamat->kode_pos }}" class="w-full border p-2 rounded" required>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="is_default" value="1" {{ $alamat->is_default ? 'checked' : '' }}>
                                    <span>Jadikan default</span>
                                </label>
                            </div>
                            <div class="mt-4 flex justify-end space-x-2">
                                <button type="button" onclick="document.getElementById('modalEditAlamat{{ $alamat->id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- MODAL HAPUS -->
                <div id="modalHapusAlamat{{ $alamat->id }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden z-50">
                    <div class="bg-white rounded-lg p-6 w-full max-w-sm relative">
                        <button onclick="document.getElementById('modalHapusAlamat{{ $alamat->id }}').classList.add('hidden')" class="absolute top-3 right-3 text-gray-600">&times;</button>
                        <h3 class="text-lg font-bold mb-4">Konfirmasi Hapus</h3>
                        <p>Apakah Anda yakin ingin menghapus alamat <strong>{{ $alamat->label }}</strong>?</p>
                        <div class="mt-4 flex justify-end space-x-2">
                            <button type="button" onclick="document.getElementById('modalHapusAlamat{{ $alamat->id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                            <form action="{{ route('profile.alamatDelete', $alamat) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>

    </div>
</div>

<!-- MODAL TAMBAH ALAMAT -->
<div id="modalTambahAlamat" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg relative">
        <button onclick="document.getElementById('modalTambahAlamat').classList.add('hidden')" class="absolute top-3 right-3 text-gray-600">&times;</button>
        <h3 class="text-lg font-bold mb-4">Tambah Alamat Baru</h3>

        <form method="POST" action="{{ route('profile.alamatStore') }}">
            @csrf
            <div class="space-y-3">
                <input type="text" name="label" placeholder="Label (misal: Rumah)" class="w-full border p-2 rounded" required>
                <input type="text" name="nama_penerima" placeholder="Nama Penerima" class="w-full border p-2 rounded" required>
                <input type="text" name="telepon_penerima" placeholder="Telepon Penerima" class="w-full border p-2 rounded" required>
                <textarea name="alamat_lengkap" placeholder="Alamat Lengkap" class="w-full border p-2 rounded" required></textarea>
                <input type="text" name="kota" placeholder="Kota" class="w-full border p-2 rounded" required>
                <input type="text" name="kode_pos" placeholder="Kode Pos" class="w-full border p-2 rounded" required>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="is_default" value="1">
                    <span>Jadikan default</span>
                </label>
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('modalTambahAlamat').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Simpan</button>
            </div>
        </form>
    </div>
</div>


@endsection