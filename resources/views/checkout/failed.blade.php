@extends('layouts.main')

@section('title', 'Gagal')

@section('content')
<div class="pt-28 pb-16 min-h-screen bg-gray-50">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl text-center shadow">
        <h1 class="text-2xl font-bold mb-3 text-red-600">Checkout Gagal</h1>
        <p class="text-gray-600 mb-6">ID: {{ $transaksi->order_id }}</p>

        <a href="{{ route('checkout.index') }}" class="bg-gray-700 text-white px-6 py-3 rounded-lg">
            Coba Lagi
        </a>
    </div>
</div>
@endsection
