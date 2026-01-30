@extends('layouts.main')

@section('title', 'Penarikan Saldo')

@section('content')
<div
    x-data="withdrawPage({{ $user->saldo }})"
    class="pt-28 max-w-screen-xl mx-auto px-6">

    <div class="grid grid-cols-12 gap-6">

        {{-- ================= FORM (KIRI) ================= --}}
        <div class="col-span-8 bg-white p-6 rounded-2xl shadow">
            <h2 class="text-xl font-semibold">Ajukan Penarikan</h2>

            <form method="POST" action="{{ Route('tarik.baru')  }}">
                @csrf

                <div>
                    <label class="text-sm font-medium">Bank / E-Wallet</label>
                    <select x-model="bank" name="bank" class="w-full mt-1 border rounded-lg p-2">
                        <option value="">Pilih Bank</option>
                        <template x-for="item in banks" :key="item">
                            <option x-text="item"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">No Rekening</label>
                    <input type="text" name="norek" x-model="rekening"
                        class="w-full mt-1 border rounded-lg p-2">
                </div>

                <div>
                    <label class="text-sm font-medium">Nominal</label>
                    <input type="number" x-model="nominal" name="nominal"
                        class="w-full mt-1 border rounded-lg p-2">
                    <p class="text-xs text-red-500 mt-1"
                        x-show="error"
                        x-text="error"></p>
                </div>

                <button type="submit"
                    class="bg-red-600 text-white px-6 py-2 rounded-xl hover:bg-red-700">
                    Ajukan Penarikan
                </button>
            </form>
        </div>

        {{-- ================= KANAN ================= --}}
        <div class="col-span-4 space-y-6 self-start">

            {{-- SALDO --}}
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-sm text-gray-500">Saldo Tersedia</p>
                <h1 class="text-3xl font-bold">
                    Rp <span x-text="format(saldo)"></span>
                </h1>
            </div>

            {{-- RIWAYAT --}}
            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="font-semibold mb-4">Riwayat Penarikan</h3>

                @if ($riwayat->count())
                <ul class="space-y-3 max-h-72 overflow-y-auto">
                    @foreach ($riwayat as $r)
                    <a href="{{ route('tarik.struk',$r->id) }}">
                        <li class="flex justify-between text-sm border-b pb-2">
                        <div>
                            <p class="font-medium">
                                Rp {{ number_format($r->nominal, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $r->tujuan }} • {{ $r->tanggal_penarikan }}
                            </p>
                        </div>

                        <span class="
                                    px-2 py-1 text-xs rounded-full
                                    @if($r->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($r->status === 'success') bg-green-100 text-green-700
                                    @else bg-red-100 text-red-700
                                    @endif
                                ">
                            {{ ucfirst($r->status) }}
                        </span>
                    </li>
                    </a>
                    
                    @endforeach
                </ul>
                @else
                <p class="text-sm text-gray-500">Belum ada penarikan</p>
                @endif
            </div>

        </div>

    </div>
</div>

{{-- ================= ALPINE ================= --}}
<script>
    function withdrawPage(saldoAwal) {
        return {
            saldo: saldoAwal,
            bank: '',
            rekening: '',
            nominal: '',
            error: '',
            banks: ['BCA', 'BRI', 'BNI', 'Mandiri', 'Dana', 'OVO'],

            format(val) {
                return new Intl.NumberFormat('id-ID').format(val)
            },

            submit() {
                if (!this.bank || !this.rekening || !this.nominal) {
                    this.error = 'Semua field wajib diisi'
                    return
                }

                if (this.nominal < 50000) {
                    this.error = 'Minimal penarikan Rp 50.000'
                    return
                }

                if (this.nominal > this.saldo) {
                    this.error = 'Saldo tidak mencukupi'
                    return
                }

                this.error = ''
                this.$el.querySelector('form').submit()
            }
        }
    }
</script>
@endsection