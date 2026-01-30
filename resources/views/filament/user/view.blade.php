{{-- resources/views/filament/user/view.blade.php --}}
@extends('filament::page') {{-- gunakan layout Filament agar tampilan konsisten --}}

@section('content')
    <div class="space-y-6">

        {{-- Profil --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center gap-6">
                <div>
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto" class="w-24 h-24 rounded-full object-cover">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">No Photo</span>
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="text-2xl font-semibold">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    <p class="mt-2 text-sm">
                        <strong>Status:</strong> {{ $user->is_admin ? 'Admin' : 'User' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Alamat --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Alamat</h3>
                <span class="text-sm text-gray-500">{{ $user->alamats->count() }} alamat</span>
            </div>

            @if($user->alamats->isEmpty())
                <p class="text-sm text-gray-500">Belum ada alamat.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($user->alamats as $alamat)
                        <div class="border rounded p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="font-semibold">{{ $alamat->label }} @if($alamat->is_default) <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded ml-2">Default</span> @endif</div>
                                    <div class="text-sm text-gray-700 mt-1">{{ $alamat->nama_penerima }} — {{ $alamat->telepon_penerima }}</div>
                                </div>
                            </div>

                            <div class="mt-3 text-sm text-gray-600">
                                {{ $alamat->alamat_lengkap }}<br>
                                {{ $alamat->kota }} — {{ $alamat->kode_pos }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Riwayat Pembelian --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Riwayat Pembelian</h3>
                <span class="text-sm text-gray-500">{{ $user->transaksis->count() }} transaksi</span>
            </div>

            @if($user->transaksis->isEmpty())
                <p class="text-sm text-gray-500">Belum ada transaksi.</p>
            @else
                <div class="space-y-4">
                    @foreach($user->transaksis()->latest()->get() as $transaksi)
                        <div class="border rounded p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold">ID: {{ $transaksi->id }} — {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-600">Status: <strong>{{ $transaksi->status }}</strong></div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
                                    <div class="text-sm text-gray-500">Ekspedisi: {{ $transaksi->ekspedisi ?? '-' }}</div>
                                </div>
                            </div>

                            {{-- detail produk jika ada --}}
                            @if($transaksi->detailTransaksis && $transaksi->detailTransaksis->isNotEmpty())
                                <div class="mt-3 border-t pt-3">
                                    <div class="text-sm font-medium mb-2">Produk:</div>
                                    <ul class="text-sm space-y-1">
                                        @foreach($transaksi->detailTransaksis as $detail)
                                            <li class="flex justify-between">
                                                <div>
                                                    {{ optional($detail->produk)->nama ?? 'Produk hilang' }} x{{ $detail->jumlah }}
                                                </div>
                                                <div class="text-gray-700">
                                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
@endsection
