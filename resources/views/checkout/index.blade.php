@extends('layouts.main')
@section('title', 'Checkout')

@section('content')
<form method="POST" action="{{ route('checkout.process') }}">
    @csrf
    <div
        class="pt-28 pb-20 bg-gray-50 min-h-screen"
        x-data="checkoutData(
        {{ Js::from($alamats) }},
        {{ $alamatDefault?->id ?? 'null' }},
        {{ $items->count() }})"

        x-init="init()">

        <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8">


            <!-- LEFT -->
            <div class="lg:col-span-2 space-y-8">


                <!-- ALAMAT -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <div class="flex justify-between">
                        <h2 class="text-xl font-bold mb-4">Alamat Pengiriman</h2>
                        <button onclick="document.getElementById('modalTambahAlamat').classList.remove('hidden')" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Tambah Alamat</button>

                    </div>



                    <select x-model="selectedAlamatId" @change="fillAlamat"
                        class="w-full p-3 border rounded-xl">
                        <option value="">-- Pilih Alamat --</option>
                        @foreach($alamats as $alamat)
                        <option value="{{ $alamat->id }}">
                            {{ $alamat->label }} - {{ $alamat->alamat_lengkap }}
                        </option>
                        @endforeach
                    </select>

                    <template x-if="alamatAktif">
                        <div class="flex">
                            <div class="mt-3 p-3 bg-gray-100 rounded-lg text-sm flex flex-col gap-1">

                                <input type="hidden" name="alamat_id" x-bind:value="selectedAlamatId">
                                <p><strong x-text="alamatAktif.label"></strong></p>
                                <div>
                                    <label><span class="font-semibold ">Nama Penerima: </span></label>
                                    <input type="text" name="nama_penerima" :value="alamatAktif?.nama_penerima" class="border" required>
                                </div>
                                <div>
                                    <label><span class="font-semibold">Telepon Penerima: </span></label>
                                    <input type="text" name="telepon_penerima" :value="alamatAktif.telepon_penerima" class="border" required>
                                </div>
                                <p><strong>Alamat:</strong> <span x-text="alamatAktif.alamat_lengkap"></span></p>
                                <p><strong>Kota: </strong> <span x-text="alamatAktif.kota"></span></p>
                                <p><strong>Kode Post: </strong> <span x-text="alamatAktif.kode_pos"></span></p>


                            </div>

                            <div class="mt-3 p-3 bg-gray-100 rounded-lg text-sm flex flex-col gap-1">
                                <label for="ekspedisi">Pilih ekspedisi</label>
                                <select name="ekspedisi" id="ekspedisi" class="w-full p-3 border rounded-xl">
                                    <option value="jne">JNE</option>
                                    <option value="sicepat">Si cepat</option>
                                    <option value="jnt">JNT</option>
                                </select>

                            </div>




                        </div>
                    </template>
                </div>

                <!-- PRODUK -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-xl font-bold mb-4">Ringkasan Produk</h2>

                    @foreach($items as $item)
                    <div class="flex gap-4 border p-4 rounded-xl mb-3">
                        <img src="{{ asset('storage/'.$item->produk->gambar) }}"
                            class="w-20 h-20 rounded-xl">
                        <div class="flex-1">
                            <p class="font-semibold">{{ $item->produk->nama_produk }}</p>
                            <p class="text-sm text-gray-600">
                                {{ $item->qty }} × Rp {{ number_format($item->harga) }}
                            </p>
                        </div>
                        <strong>Rp {{ number_format($item->qty * $item->harga) }}</strong>
                    </div>
                    @endforeach
                </div>

            </div>

            <!-- RIGHT -->
            <div class="bg-white p-6 rounded-xl shadow h-fit">
                <h2 class="text-xl font-bold mb-4">Ringkasan Belanja</h2>

                <div class="flex justify-between">
                    <span>Total Item</span>
                    <span>Rp {{ number_format($cart->total()) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Ongkir</span>
                    Rp <span x-text="ongkir.toLocaleString('id-ID')"></span>
                </div>

                <input type="hidden" name="ongkir" x-bind:value="ongkir">


                <div class="flex justify-between font-bold text-lg pt-3 border-t">
                    <span>Total</span>
                    <span x-text="({{ $cart->total() }} + ongkir).toLocaleString('id-ID')"> </span>
                </div>
                <input type="hidden" name="total" x-bind:value="{{ $cart->total() }} + ongkir">



                <p x-show="!bolehBayar" class="text-sm text-gray-500 mt-4 text-center">
                    Pilih alamat pengiriman untuk melanjutkan pembayaran
                </p>
                <p x-show="totalItem === 0" class="text-sm text-red-500 mt-4 text-center">
                    Keranjang belanja kosong
                </p>




                <button
                    type="button"
                    id="btnCheckout"
                    x-show="bolehBayar"
                    x-transition
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold mt-4">
                    Bayar Sekarang
                </button>






            </div>

        </div>
    </div>
</form>

<!-- MODAL TAMBAH ALAMAT -->
<div id="modalTambahAlamat" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg relative">
        <button onclick="document.getElementById('modalTambahAlamat').classList.add('hidden')" class="absolute top-3 right-3 text-gray-600">&times;</button>
        <h3 class="text-lg font-bold mb-4">Tambah Alamat Baru</h3>

        <form method="POST" action="{{ route('checkout.alamatStore') }}">
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


<!-- MIDTRANS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.clientKey') }}"></script>

<!-- ALPINE LOGIC -->
<script>
    function checkoutData(alamats, defaultId, totalItem) {
        return {
            alamats,
            selectedAlamatId: defaultId,
            alamatAktif: null,
            ongkir: 0,
            totalItem,

            init() {
                if (this.selectedAlamatId) {
                    this.fillAlamat()
                }
            },

            fillAlamat() {
                this.alamatAktif = this.alamats.find(
                    a => a.id == this.selectedAlamatId
                )
                if (!this.alamatAktif) return

                const kota = this.alamatAktif.kota.toLowerCase()

                if (['semarang', 'jogja', 'kendal', 'banjarnegara', 'purbalingga', 'magelang', 'cirebon'].includes(kota)) {
                    this.ongkir = 16000
                } else if (['pekalongan', 'batang', 'pemalang'].includes(kota)) {
                    this.ongkir = 8000
                } else if (['jakarta', 'surabaya', 'malang', 'bandung'].includes(kota)) {
                    this.ongkir = 23000
                } else {
                    this.ongkir = 32000
                }
            },

            get bolehBayar() {
                return this.alamatAktif && this.totalItem > 0
            }
        }
    }


    document.getElementById('btnCheckout').addEventListener('click', function() {
        fetch("{{ route('checkout.process') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    alamat_id: document.querySelector('[name="alamat_id"]').value,
                    nama_penerima: document.querySelector('[name="nama_penerima"]').value,
                    telepon_penerima: document.querySelector('[name="telepon_penerima"]').value,
                    ekspedisi: document.querySelector('[name="ekspedisi"]').value,
                    ongkir: document.querySelector('[name="ongkir"]').value,
                    total: document.querySelector('[name="total"]').value,
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = "/checkout/success/" + data.transaksi_id;
                        },
                        onPending: function(result) {
                            console.log('Pending', result);
                        },
                        onError: function(result) {
                            window.location.href = "/checkout/failed/" + data.transaksi_id;
                        },
                        onClose: function() {
                            alert('Popup ditutup, pembayaran belum selesai');
                            window.location.href = "/checkout/pending/" + data.transaksi_id;
                        }
                    });
                } else {
                    alert(data.error || 'Gagal checkout');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan');
            });
    });
</script>
@endsection