<div id="modalTambahAlamat" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg relative">
        <button @click="document.getElementById('modalTambahAlamat').classList.add('hidden')" class="absolute top-3 right-3 text-gray-600">&times;</button>
        <h3 class="text-lg font-bold mb-4">Tambah Alamat</h3>

        <form method="POST" action="{{ route('profile.alamatStore') }}">
            @csrf
            <div class="space-y-3">
                <input type="text" name="label" placeholder="Label (Rumah/Kantor)" class="w-full border p-2 rounded">
                <input type="text" name="nama_penerima" placeholder="Nama Penerima" class="w-full border p-2 rounded">
                <input type="text" name="telepon_penerima" placeholder="Telepon Penerima" class="w-full border p-2 rounded">
                <textarea name="alamat_lengkap" placeholder="Alamat Lengkap" class="w-full border p-2 rounded"></textarea>
                <input type="text" name="kota" placeholder="Kota" class="w-full border p-2 rounded">
                <input type="text" name="kode_pos" placeholder="Kode Pos" class="w-full border p-2 rounded">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="is_default" value="1">
                    <span>Jadikan default</span>
                </label>
            </div>

            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" @click="document.getElementById('modalTambahAlamat').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
