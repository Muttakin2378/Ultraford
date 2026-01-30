@extends('layouts.main')

@section('title','Detail Pesanan')

@section('content')
<div class="pt-28 max-w-5xl mx-auto px-4">

    <!-- HEADER -->
    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">
                    Detail Pesanan
                </h2>
                <p class="text-sm text-gray-500">
                    Order ID: <span class="font-medium">{{ $pesanan->order_id }}</span>
                </p>
                <p class="text-sm text-gray-500">
                    Tanggal Order: <span class="font-medium">{{ $pesanan->tanggal_transaksi }}</span>
                </p>
            </div>

            <!-- STATUS -->
            <span class="px-4 py-1 rounded-full text-sm font-semibold {{ $pesanan->status_color }}">
                {{ ucfirst($pesanan->status) }}
                @if($pesanan->status==='return')
                <p>( {{$pesanan->returnOrder->status}} )</p>
                @endif
            </span>

        </div>
    </div>

    <!-- INFORMASI PENERIMA -->
    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <h3 class="font-semibold text-lg mb-4">Informasi Pengiriman</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Nama Penerima</p>
                <p class="font-medium">{{ $pesanan->nama_penerima }}</p>
            </div>

            <div>
                <p class="text-gray-500">No. Telepon</p>
                <p class="font-medium">{{ $pesanan->no_telp_penerima }}</p>
            </div>

            <div>
                <p class="text-gray-500">Alamat</p>
                <p class="font-medium">
                    {{ $pesanan->alamat->alamat_lengkap ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Ekspedisi</p>
                <p class="font-medium">{{ strtoupper($pesanan->ekspedisi) }}</p>
            </div>

            @if($pesanan->no_resi)
            <div>
                <p class="text-gray-500">No. Resi</p>
                <p class="font-medium">{{ $pesanan->no_resi }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- DETAIL PRODUK -->
    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <h3 class="font-semibold text-lg mb-4">Produk Dipesan</h3>

        <div class="divide-y">
            @foreach ($pesanan->detailTransaksis as $item)
            <div class="flex gap-4 items-center p-4 border rounded-xl bg-white shadow-sm mb-4">

                {{-- GAMBAR --}}
                <img
                    src="{{ asset('storage/' . $item->produk->gambar) }}"
                    class="w-20 h-20 object-cover rounded-lg border">

                {{-- INFO PRODUK --}}
                <div class="flex-1">
                    <p class="font-semibold text-gray-800">
                        {{ $item->produk->nama_produk }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ $item->jumlah }} × Rp {{ number_format($item->harga_satuan ?? $item->produk->harga_jual,0,',','.') }}
                    </p>

                    {{-- ================= ULASAN ================= --}}
                    @if($pesanan->status === 'selesai')

                    @php
                    $sudahReview = $item->produk->reviews()
                    ->where('user_id', auth()->id())
                    ->exists();
                    @endphp

                    <div class="mt-4 bg-gray-50 p-4 rounded-xl border">

                        @if(!$sudahReview)
                        {{-- FORM REVIEW --}}
                        <form action="{{ route('review') }}" method="POST"
                            x-data="{ rating: 0 }" x-cloak>

                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $item->produk->id }}">
                            <input type="hidden" name="rating" :value="rating">

                            <p class="font-semibold text-sm mb-2">Beri Ulasan Produk</p>

                            <!-- ⭐ STAR RATING -->
                            <div class="flex gap-1 mb-3">
                                <template x-for="i in 5" :key="i">
                                    <div
                                        @click="rating = i"
                                        class="cursor-pointer">
                                        <svg
                                            class="w-6 h-6 transition"
                                            :class="i <= rating ? 'text-yellow-400' : 'text-gray-300'"
                                            fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97h4.173c.969 0 1.371 1.24.588 1.81l-3.377 2.454 1.286 3.97c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.377 2.452c-.784.57-1.838-.197-1.539-1.118l1.286-3.97L3.002 8.707c-.783-.57-.38-1.81.588-1.81h4.173l1.286-3.97z" />
                                        </svg>
                                    </div>
                                </template>
                            </div>

                            <!-- KOMENTAR -->
                            <textarea
                                name="komen"
                                required
                                rows="3"
                                class="w-full border rounded-lg p-2 text-sm mb-3"
                                placeholder="Tulis ulasan kamu..."></textarea>

                            <button
                                type="submit"
                                :disabled="rating === 0"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm disabled:opacity-50">
                                Kirim Ulasan
                            </button>
                        </form>



                        @else
                        {{-- SUDAH REVIEW --}}
                        <div class="flex items-center gap-2 text-green-600 text-sm font-medium">
                            ✔ Kamu sudah memberikan ulasan untuk produk ini
                        </div>
                        @endif

                    </div>
                    @endif
                    {{-- ================= END ULASAN ================= --}}

                </div>

                {{-- SUBTOTAL --}}
                <div class="text-right">
                    <p class="font-semibold text-gray-800">
                        Rp {{ number_format($item->subtotal,0,',','.') }}
                    </p>
                </div>
            </div>


            @endforeach
            <p class="font-semibold text-right text-bold">
                Rp {{ number_format($pesanan->detailTransaksis->sum('subtotal'),0,',','.') }}
            </p>


        </div>
    </div>

    <!-- TOTAL -->
    <hr class="my-6">

    <div class="bg-gray-50 p-4 rounded-xl">
        <div class="flex justify-between mb-2">
            <span class="text-gray-600">Total Produk</span>
            <span class="font-semibold">
                Rp {{ number_format($pesanan->detailTransaksis->sum('subtotal'),0,',','.') }}
            </span>
        </div>

        <div class="flex justify-between mb-2">
            <span class="text-gray-600">Ongkir</span>
            <span class="font-semibold">
                Rp {{ number_format($pesanan->ongkir,0,',','.') }}
            </span>
        </div>

        <div class="flex justify-between text-lg font-bold text-green-700">
            <span>Total Pembayaran</span>
            <span>
                Rp {{ number_format($pesanan->total_harga,0,',','.') }}
            </span>
        </div> <br>
        @if($pesanan->status === 'pending')
        <div class="flex justify-between gap-4">
            <form action="{{ route('pesanan.batal', $pesanan->id) }}" method="POST" class="w-full">
                @csrf
                <button
                    type="submit"
                    onclick="return confirm('Yakin ingin membatalkan pesanan?')"
                    class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                    Batalkan
                </button>
            </form>
            <button
                onclick="event.preventDefault(); event.stopPropagation(); payAgain('{{ $pesanan->snap_token }}', '{{ $pesanan->id }}' )"
                class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                Bayar Sekarang
            </button>
        </div>
        @endif

        @if($pesanan->status === 'dikemas')
        <form action="{{ route('pesanan.batal', $pesanan->id) }}" method="POST" class="w-full">
            @csrf
            <button
                type="submit"
                onclick="return confirm('Yakin ingin membatalkan pesanan?')"
                class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                Batalkan
            </button>
        </form>
        @endif
        @if($pesanan->status === 'diterima' )
        <form action="{{ route('pesanan.batal', $item->id) }}" method="POST" class="w-full">
            @csrf
            <div class="flex justify-between gap-4">
                <button
                    type="submit"
                    onclick="return confirm('Yakin ingin membatalkan pesanan?')"
                    class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold">
                    Batalkan
                </button>
        </form>
        <button
            onclick="event.preventDefault(); event.stopPropagation(); payAgain('{{ $pesanan->snap_token }}', '{{ $pesanan->id }}' )"
            class="w-full bg-teal-600 text-white py-3 rounded-lg font-semibold">
            Pesanan Diterima
        </button>
    </div>
    @endif
</div>

<br>
<br>

</div>
<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.clientKey') }}">
</script>
<script>
    function payAgain(snapToken, transaksiId) {
        snap.pay(snapToken, {
            onSuccess: function(result) {
                window.location.href = "/checkout/success/" + transaksiId;
            },
            onPending: function() {
                alert('Pembayaran masih pending');
            },
            onClose: function() {
                alert('Pembayaran dibatalkan');
            }
        });
    }
</script>
@endsection