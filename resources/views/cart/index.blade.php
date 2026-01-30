@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="pt-28 pb-20 bg-gray-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-4">

        <h1 class="text-3xl font-bold mb-8">Keranjang Belanja</h1>

        @if ($items->count() == 0)
        <div class="bg-white p-10 rounded-xl shadow text-center">
            <p class="text-gray-700 text-lg">Keranjang kamu masih kosong.</p>
            <a href="{{ route('katalog') }}"
                class="mt-4 inline-block bg-green-600 text-white px-6 py-3 rounded-xl shadow hover:bg-green-700">
                Belanja Sekarang
            </a>
        </div>
        @else

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- List Item Keranjang -->
            <div class="lg:col-span-2 space-y-4">
                @foreach ($items as $item)
                <div class="bg-white p-4 rounded-xl shadow flex gap-4 items-center">

                    <!-- Gambar Produk -->
                    <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                        class="w-28 h-28 rounded-lg object-cover">

                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $item->produk->nama_produk }}
                        </h3>

                        <p class="text-green-700 font-bold">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </p>

                        <!-- Qty Controls -->
                        <div class="flex items-center mt-3 space-x-2">

                            {{-- Kurangi --}}
                            <form action="{{ route('keranjang.updateQty', $item->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="qty" value="{{ max(1, $item->qty - 1) }}">
                                <button type="submit"
                                    class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center">
                                    -
                                </button>
                            </form>

                            {{-- Input manual --}}
                            <form action="{{ route('keranjang.updateQty', $item->id) }}" method="POST">
                                @csrf
                                <input
                                    type="number"
                                    name="qty"
                                    min="1"
                                    value="{{ $item->qty }}"
                                    class="w-14 text-center border rounded-lg py-1"
                                    onchange="this.form.submit()">
                            </form>

                            {{-- Tambah --}}
                            <form action="{{ route('keranjang.updateQty', $item->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
                                <button type="submit"
                                    class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center">
                                    +
                                </button>
                            </form>

                            {{-- Hapus --}}
                            <form action="{{ route('keranjang.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="ml-3 text-red-500 hover:text-red-700">
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </div>

                </div>
                @endforeach
            </div>

            <!-- Ringkasan Belanja -->
            <div class="bg-white p-6 rounded-xl shadow h-fit">

                <h2 class="text-xl font-bold mb-4">Ringkasan Belanja</h2>

                @php
                $total = $items->sum(fn($i) => $i->qty * $i->harga);
                @endphp

                <div class="flex justify-between mb-2 text-gray-700">
                    <span>Total Barang</span>
                    <span>{{ $items->sum('qty') }}</span>
                </div>

                <div class="flex justify-between mb-5 text-gray-800 text-lg font-semibold">
                    <span>Total Harga</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <a href="{{ route('checkout.index') }}"
                    class="block text-center bg-green-600 text-white py-3 rounded-xl shadow hover:bg-green-700 mb-3">
                    Checkout
                </a>

                <a href="{{ route('katalog') }}"
                    class="block text-center bg-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-300">
                    Lanjut Belanja
                </a>

            </div>

        </div>
        @endif

    </div>
</div>
@endsection