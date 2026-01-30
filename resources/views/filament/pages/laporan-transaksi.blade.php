<x-filament::page>
    <a
    href="{{ route('laporan.transaksi.cetak') }}"
    target="_blank"
    class="filament-button filament-button-color-primary"
>
    Cetak Laporan
</a>
    {{ $this->table }}
</x-filament::page>
