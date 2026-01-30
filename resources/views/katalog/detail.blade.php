@extends('layouts.main')

@section('title', $produk->nama_produk)

@section('content')
<div class="pt-28 pb-20 bg-gray-50">

    <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-14">

        {{-- FOTO + GALERI --}}
        <div class="space-y-4">
            <div class="bg-white rounded-3xl shadow p-4">
                <img
                    src="{{ asset('storage/' . $produk->gambar) }}"
                    onclick="openImage(this.src)"
                    class="cursor-pointer w-full rounded-2xl object-cover transition hover:scale-[1.02]">
            </div>

            @if ($produk->gambars->count())
            <div class="grid grid-cols-4 gap-3">
                @foreach ($produk->gambars as $g)
                <img
                    src="{{ asset('storage/' . $g->path_gambar) }}"
                    onclick="openImage(this.src)"
                    class="cursor-pointer bg-white rounded-xl shadow h-20 w-full object-cover hover:scale-105 transition">
                @endforeach
            </div>
            @endif
        </div>

        {{-- DETAIL --}}
        <div class="space-y-6">

            <h1 class="text-4xl font-extrabold text-gray-900">
                {{ $produk->nama_produk }}
            </h1>

            {{-- Harga + Jenis --}}
            <div class="flex items-center gap-4">
                <p class="text-green-700 text-3xl font-extrabold">
                    Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                </p>
                <span class="px-4 py-1.5 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                    {{ ucfirst($produk->jenis) }}
                </span>
            </div>

            {{-- Stok + Rating --}}
            <div class="flex justify-between items-center bg-white p-4 rounded-2xl shadow">
                <span class="text-sm text-gray-500">
                    Stok: {{ $produk->stok }} | Terjual: {{ $produk->totalTerjual() }}
                </span>

                @php
                $avgRating = round($produk->reviews()->avg('rating'), 1);
                $totalReview = $produk->reviews()->count();
                @endphp

                <div class="flex items-center gap-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= floor($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97h4.173c.969 0 1.371 1.24.588 1.81l-3.377 2.454 1.286 3.97c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.377 2.452c-.784.57-1.838-.197-1.539-1.118l1.286-3.97L3.002 8.707c-.783-.57-.38-1.81.588-1.81h4.173l1.286-3.97z" />
                        </svg>
                        @endfor
                        <span class="text-sm text-gray-600">
                            {{ $avgRating ?: '0.0' }} ({{ $totalReview }})
                        </span>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-lg font-bold mb-2">Deskripsi Produk</h3>
                <p class="text-gray-700 leading-relaxed">
                    {{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>

            {{-- Aksi --}}
            @if($produk->stok > 0)
            <div class="grid grid-cols-2 gap-4">
                <form action="{{ route('keranjang.tambah', $produk->id) }}" method="POST">
                    @csrf
                    <button class="w-full bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700">
                        Tambah ke Keranjang
                    </button>
                </form>


            </div>
            @else
            <div class="bg-white p-8 rounded-2xl shadow text-center text-gray-600">
                Produk habis.
            </div>
            @endif
        </div>
    </div>

    {{-- ULASAN --}}
    <div class="max-w-4xl mx-auto px-4 mt-20">
        <h2 class="text-2xl font-bold mb-6">Ulasan Pembeli</h2>

        <div class="space-y-4">
            @forelse($produk->reviews()->latest()->get() as $review)
            <div class="bg-white p-5 rounded-2xl shadow">
                <div class="flex justify-between mb-1">
                    <strong>{{ $review->user->name ?? 'Pembeli' }}</strong>
                    <div class="flex">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97h4.173c.969 0 1.371 1.24.588 1.81l-3.377 2.454 1.286 3.97c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.377 2.452c-.784.57-1.838-.197-1.539-1.118l1.286-3.97L3.002 8.707c-.783-.57-.38-1.81.588-1.81h4.173l1.286-3.97z" />
                            </svg>
                            @endfor
                    </div>
                </div>
                <p class="text-gray-700">{{ $review->komen }}</p>
            </div>
            @empty
            <p class="text-gray-500">Belum ada ulasan.</p>
            @endforelse
        </div>
    </div>

    {{-- PRODUK TERKAIT --}}
    <div class="max-w-7xl mx-auto px-4 mt-20">
        <h2 class="text-2xl font-bold mb-6 text-gray-900">Produk Terkait</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6"> @foreach ($related as $item) <a href="{{ route('produk.detail', $item->id) }}" class="bg-white rounded-2xl shadow hover:shadow-lg transition p-4 block"> <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-44 object-cover rounded-xl transition hover:scale-[1.03]">
                <p class="mt-3 font-semibold text-gray-900"> {{ $item->nama_produk }} </p>
                <p class="text-green-700 font-bold text-lg"> Rp {{ number_format($item->harga_jual, 0, ',', '.') }} </p>
            </a> @endforeach </div>
    </div>
</div>

{{-- IMAGE VIEWER --}}
<div id="imageModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-[9999]">
    <img id="modalImage" class="max-w-[95%] max-h-[95%] rounded-xl shadow-2xl">
</div>

<script>
    function openImage(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
    }
    document.getElementById('imageModal').onclick = e => {
        if (e.target.id === 'imageModal') e.target.classList.add('hidden');
    }
</script>
@endsection