@extends('layouts.main')

@section('title', 'Tambah Alamat')

@section('content')
<div class="container mx-auto py-24 px-4">
    <h1 class="text-3xl font-bold mb-8">Tambah Alamat</h1>

    <form action="{{ route('alamat.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-8 max-w-lg">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Alamat</label>
            <input type="text" name="alamat" value="{{ old('alamat') }}"
                   class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-lime-500">
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('profile') }}" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 rounded-lg bg-lime-500 hover:bg-lime-600 text-white font-medium">Simpan</button>
        </div>
    </form>
</div>
@endsection
