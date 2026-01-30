@extends('layouts.main')

@section('title', 'Konfirmasi Return')

@section('content')
<div class="pt-28 max-w-4xl mx-auto px-4">

    <h1 class="text-3xl font-bold mb-6">Konfirmasi Return Pesanan</h1>

    <!-- DATA PESANAN -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <p class="font-semibold mb-2">
            Order ID: {{ $transaksi->order_id }}
        </p>
        <p class="text-sm text-gray-500 mb-4">
            Tanggal: {{ $transaksi->tanggal_transaksi }}
        </p>

        @foreach($transaksi->detailTransaksis as $item)
        <div class="flex justify-between text-sm mb-1">
            <span>{{ $item->produk->nama_produk }} x{{ $item->jumlah }}</span>
            <span>Rp {{ number_format($item->subtotal,0,',','.') }}</span>
        </div>
        @endforeach

        <hr class="my-3">

        <div class="flex justify-between font-bold text-green-700">
            <span>Total</span>
            <span>Rp {{ number_format($transaksi->total_harga,0,',','.') }}</span>
        </div>
    </div>

    <!-- FORM RETURN -->
    <div class="bg-white rounded-xl shadow p-6">
        <form
            action="{{ route('pesanan.return.store', $transaksi->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-2">
                    Alasan Return
                </label>
                <textarea
                    name="alasan"
                    required
                    class="w-full border rounded-lg p-2"
                    rows="4"
                    placeholder="Tuliskan alasan return..."
                >{{ old('alasan') }}</textarea>

                @error('alasan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">
                    Foto Bukti
                </label>
                <input
                    type="file"
                    name="foto"
                    accept="image/*"
                    required
                    class="w-full"
                >

                @error('foto')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a
                    href="{{ route('pesanan.saya') }}"
                    class="px-4 py-2 bg-gray-300 rounded-lg"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    onclick="return confirm('Yakin ingin mengajukan return?')"
                    class="px-4 py-2 bg-orange-600 text-white rounded-lg"
                >
                    Kirim Return
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
