<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use App\Models\Notif;
use App\Models\ReturnOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $listStatus = [
            'pending',
            'dikemas',
            'dikirim',
            'diterima',
            'selesai',
            'dibatalkan',
            'return',
        ];

        $pesanan = Transaksi::with(['detailTransaksis.produk','returnOrder'])
            ->where('user_id', Auth::id())
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->orderBy('tanggal_transaksi', 'DESC')
            ->get();

        return view('pesanan.index', compact(
            'pesanan',
            'status',
            'listStatus'
        ));
    }
    public function show($id)
    {
        $pesanan = Transaksi::with(['detailTransaksis.produk', 'alamat'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pesanan.detail', compact('pesanan'));
    }
    public function batal($id)
    {
        $pesanan = Transaksi::findOrFail($id);
        /** @var User $user */
        $user = Auth::user();



        if ($pesanan->status !== 'pending' && $pesanan->status !== 'dikemas') {
            return redirect()->back()->with('error', 'Pesanan Tidak dapat di batalkan');
        }
        if ($pesanan->status === 'dikemas') {
            $user->saldo += $pesanan->total_harga;
            $user->save();
        }
        $pesanan->status = 'dibatalkan';
        $pesanan->tanggal_batal = now();
        $pesanan->save();
        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'Pesanan ' . $pesanan->order_id . 'telah di batalkan ',
            'status' => 'belum_dibaca',
        ]);

        return redirect()->route('pesanan.saya', [
            'status' => 'dibatalkan'
        ])->with('success', 'Pesanan berhasil dibatalkan');
    }
    public function diterima($id)
    {
        $pesanan = Transaksi::findOrFail($id);
        $pesanan->status = 'selesai';
        $pesanan->tanggal_selesai = now();
        $pesanan->save();
        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'Pesanan ' . $pesanan->order_id . 'telah telah selesai',
            'status' => 'belum_dibaca',
        ]);

        return redirect()->route('pesanan.saya', [
            'status' => 'selesai'
        ])->with('succes', 'Pesanan selesai');
    }
    public function returnForm($id)
    {
        $transaksi = Transaksi::with('detailTransaksis.produk')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pesanan.return', compact('transaksi'));
    }

    public function returnStore(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|min:5',
            'foto'   => 'required|image'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $path = $request->file('foto')->store('return', 'public');

        ReturnOrder::create([
            'transaksi_id' => $transaksi->id,
            'user_id'      => Auth::id(),
            'no_resi'      =>$transaksi->ekspedisi.time(),
            'alasan'       => $request->alasan,
            'foto_bukti'   => $path,
        ]);

        $transaksi->update([
            'status' => 'return',
            'tanggal_batal' => now()
        ]);

        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'Pesanan ' . $transaksi->order_id . 'telah dalam proses return ',
            'status' => 'belum_dibaca',
        ]);

        return redirect()
            ->route('pesanan.saya', ['status' => 'return'])
            ->with('success', 'Return berhasil diajukan');
    }
}
