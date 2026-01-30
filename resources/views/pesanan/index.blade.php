@extends('layouts.main')

@section('title', 'Pesanan Saya')

@section('content')
<div class="pt-28 pb-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">

        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">
            Pesanan Saya
        </h1>

        <!-- FILTER STATUS -->
        <div class="flex items-center justify-center gap-4 mb-10 flex-wrap">

            @foreach ($listStatus as $st)
            <a href="{{ route('pesanan.saya', ['status' => $st]) }}"
                class="px-5 py-2 rounded-full border 
                    {{ $status == $st ? 'bg-green-600 text-white border-green-600' : 'text-gray-700 border-gray-300' }}">
                {{ $st }}
            </a>
            @endforeach
        </div>

        <!-- LIST PESANAN -->
        @forelse ($pesanan as $item)
        <a href="{{ route('pesanan.detail', $item->id) }}">

            <div class="bg-white rounded-xl shadow p-5 mb-5 border">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <p class="font-semibold">
                            Order ID: {{ $item->order_id ?? '-' }}
                        </p>
                        <p>No Resi :{{ $item->no_resi}}</p>
                        <p class="text-sm text-gray-500">
                            {{ $item->tanggal_transaksi }}
                        </p>
                    </div>


                    <span class="px-4 py-1 rounded-full text-sm font-semibold {{ $item->status_color }}">
                        {{ ucfirst($item->status) }}
                        @if($item->status==='return')
                        <p>( {{$item->returnOrder->status}} )</p>
                        @endif
                    </span>

                </div>

                <!-- DETAIL PRODUK -->
                @foreach ($item->detailTransaksis as $detail)
                <div class="flex justify-between text-sm mb-1">
                    <span>{{ $detail->produk->nama_produk }} x{{ $detail->jumlah }}</span>
                    <span>Rp {{ number_format($detail->subtotal,0,',','.') }}</span>
                </div>
                @endforeach

                <hr class="my-3">

                <div class="flex justify-between font-bold text-green-700">
                    <span>Total</span>
                    <span>Rp {{ number_format($item->total_harga,0,',','.') }}</span>
                </div>

                @if($item->status === 'pending')
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
                    onclick="event.preventDefault(); event.stopPropagation(); payAgain('{{ $item->snap_token }}', '{{ $item->id }}' )"
                    class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold">
                    Bayar Sekarang
                </button>
            </div>


            @endif

            @if($item->status === 'dikemas')
            <form action="{{ route('pesanan.batal',$item->id) }}" method="POST" class="w-full">
                @csrf
                <button
                    type="submit"
                    onclick="return confirm('Apakah anda yakin untuk membatalkan Pesanan ini?')"
                    class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold">
                    Batalkan

                </button>
            </form>
            @endif

            @if($item->status === 'diterima')

            <div class="flex justify-between gap-4">

                <form action="{{ route('pesanan.return.form', $item->id)}}" method="GET" class="w-full">
                    @csrf
                    <button
                        onclick="return confirm('Apakah anda yakin ?')"
                        class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold">
                        Return
                    </button>
                </form>

                <form action="{{ route('pesanan.diterima', $item->id)}}" method="POST" class="w-full">
                    @csrf
                    <button
                        onclick="return confirm('Apakah anda yakin untuk menyelesaikan pesanan?')"
                        class="w-full bg-teal-600 text-white py-3 rounded-lg font-semibold">
                        Pesanan Diterima
                    </button>
                </form>
            </div>


            @endif
    </div>
    </a>
    @empty
    <div class="text-center text-gray-500 py-16">
        Belum ada pesanan
    </div>
    @endforelse

</div>
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