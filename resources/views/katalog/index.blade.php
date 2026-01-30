@extends('layouts.main')

@section('title', 'Katalog Produk')

@section('content')
<div class="pt-28 pb-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">

        <!-- TITLE -->
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">
            Katalog Produk
        </h1>

        <!-- FILTER KATEGORI -->
        <div class="flex items-center justify-center gap-4 mb-10 flex-wrap">
            @php
            $allKategori = ['tent', 'cooking_set', 'sleeping_system', 'bag'];
            @endphp

            <!-- Tombol "Semua" -->
            <a href="{{ route('katalog') }}"
                class="px-5 py-2 rounded-full border 
                {{ !$jenis ? 'bg-green-600 text-white border-green-600' : 'text-gray-700 border-gray-300' }}
                hover:bg-green-600 hover:text-white transition">
                Semua
            </a>

            <!-- List kategori -->
            @foreach ($allKategori as $kat)
            <a href="{{ route('katalog') }}?jenis={{ $kat }}"
                class="px-5 py-2 rounded-full border capitalize
                    {{ $jenis == $kat ? 'bg-green-600 text-white border-green-600' : 'text-gray-700 border-gray-300' }}
                    hover:bg-green-600 hover:text-white transition">
                {{ str_replace('_', ' ', $kat) }}
            </a>
            @endforeach
        </div>

       <!-- GRID PRODUK -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-8">
    @foreach ($produk as $item)
    <a href="{{ route('produk.detail', $item->id) }}"
        class="bg-white rounded-2xl shadow-md hover:shadow-xl p-4 transition group border border-gray-100">

        <!-- FOTO UTAMA -->
        <div class="overflow-hidden rounded-xl">
            <img src="{{ asset('storage/' . $item->gambar) }}"
                class="w-full h-48 object-cover rounded-xl group-hover:scale-110 transition duration-300">
        </div>

        <!-- INFO PRODUK -->
        <p class="mt-4 font-semibold text-gray-900 group-hover:text-green-700 transition">
            {{ $item->nama_produk }}
        </p>

        <!-- HARGA + TERJUAL -->
        <div class="flex justify-between items-center mt-2">
            <p class="text-green-700 font-extrabold text-lg">
                Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
            </p>

            <span class="text-sm text-gray-500">
                Terjual: {{ $item->totalTerjual() }}
            </span>
        </div>
    </a>
    @endforeach
</div>


    </div>
</div>
@endsection