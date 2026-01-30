<div
    x-cloak
    x-show="showModalAlamat"
    x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center"
>
    <div
        x-show="showModalAlamat"
        x-transition.scale
        class="bg-white rounded-xl p-6 w-full max-w-lg relative shadow-lg"
    >

        <!-- Close -->
        <button
            @click="showModalAlamat = false"
            class="absolute top-3 right-3 text-gray-600 text-2xl">
            &times;
        </button>

        <h3 class="text-lg font-bold mb-4">Tambah Alamat Baru</h3>

        <form method="POST" action="{{ route('profile.alamatStore') }}">
            @csrf

            <div class="space-y-3">
                <input name="label" placeholder="Label (Rumah/Kantor)"
                    class="w-full border p-2 rounded" required>

                <input name="nama_penerima" placeholder="Nama Penerima"
                    class="w-full border p-2 rounded" required>

                <input name="telepon_penerima" placeholder="Telepon"
                    class="w-full border p-2 rounded" required>

                <textarea name="alamat_lengkap" placeholder="Alamat Lengkap"
                    class="w-full border p-2 rounded" required></textarea>

                <input name="kota" placeholder="Kota"
                    class="w-full border p-2 rounded" required>

                <input name="kode_pos" placeholder="Kode Pos"
                    class="w-full border p-2 rounded" required>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_default" value="1">
                    Jadikan alamat utama
                </label>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button type="button"
                    @click="showModalAlamat=false"
                    class="px-4 py-2 bg-gray-300 rounded">
                    Batal
                </button>

                <button
                    class="px-4 py-2 bg-teal-600 text-white rounded">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>