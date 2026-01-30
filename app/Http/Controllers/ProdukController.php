<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use App\Models\Produk;
use App\Models\Riview;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use function Symfony\Component\Clock\now;

class ProdukController extends Controller
{
    public function katalog(Request $request)
    {
        $kategori = ['tent', 'cooking_set', 'sleeping_system', 'bag'];
        $jenis = $request->query('jenis');

        $produk = Produk::with('gambars')
            ->when($jenis, fn($q) => $q->where('jenis', $jenis))
            ->orderBy('nama_produk', 'ASC')
            ->get();

        return view('katalog.index', compact('produk', 'kategori', 'jenis'));
    }

    public function detail($id)
    {
        $produk = Produk::with('gambars')->findOrFail($id);

        $related = Produk::where('jenis', $produk->jenis)
            ->where('id', '!=', $produk->id)
            ->limit(4)
            ->get();

        return view('katalog.detail', compact('produk', 'related'));
    }

    public function riview(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);

        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'rating' => 'required|integer|min:1|max:5',
            'komen' => 'required|string|max:500',
        ]);

        Riview::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'produk_id' => $request->produk_id
            ],
            [
                'rating' => $request->rating,
                'komen' => $request->komen
            ]
        );

        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'Anda telah membeli ulasan pada ' . $produk->nama ,
            'status' => 'belum_dibaca',
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim');
    }
}
