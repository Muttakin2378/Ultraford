@extends('layouts.main')

@section('title', 'Berhasil')

@section('content')
<div class="pt-28 pb-16 min-h-screen bg-gray-50">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl text-center shadow ">
        <h1 class="text-2xl font-bold mb-3">Pesanan Berhasil Dibuat!</h1>
        <p class="text-gray-600 mb-6">ID Pesanan: <strong>{{ $transaksi->order_id }}</strong></p>
        <div class="flex justify-between gap-4">
            <a href="{{ route('katalog') }}" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold mt-4">
                Belanja Lagi
            </a>

            <a href="{{ route('pesanan.saya') }}" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-lg font-semibold mt-4">
                Pesanan Saya
            </a>
        </div>


    </div>
</div>
@endsection