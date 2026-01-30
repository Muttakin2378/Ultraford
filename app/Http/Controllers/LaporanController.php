<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function cetak(Request $request)
    {
        $bulan = $request->filled('bulan') ? (int) $request->bulan : now()->month;
        $tahun = $request->filled('tahun') ? (int) $request->tahun : now()->year;

        $query = Transaksi::with(['user', 'detailTransaksis.produk'])
            ->whereYear('tanggal_transaksi', $tahun)
            ->whereMonth('tanggal_transaksi', $bulan);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->get();
        $total = $transaksis->sum('total_harga');
        $admin = Auth::user();

        return view('laporan.transaksi-cetak', compact(
            'transaksis',
            'total',
            'bulan',
            'tahun',
            'admin',
        ));
    }
}
