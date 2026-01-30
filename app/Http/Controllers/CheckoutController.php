<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\Notif;
use App\Models\DetailTransaksi;
use App\Models\Alamat;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $cart = Cart::with('items.produk')
            ->where('user_id', $user->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang masih kosong');
        }


        foreach ($cart->items as $item) {

            if (!$item->produk) {
                return redirect()->route('cart.index')
                    ->with('error', 'Produk tidak ditemukan');
            }

            if ($item->qty > $item->produk->stok) {
                return redirect()->back()
                    ->with(
                        'error',
                        'Stok produk "' . $item->produk->nama_produk .
                            '" tersisa ' . $item->produk->stok .
                            '. Silakan sesuaikan jumlah.'
                    );
            }
        }

        $alamatDefault = $user->alamats()->where('is_default', 1)->first();

        return view('checkout.index', [
            'cart' => $cart,
            'items' => $cart->items,
            'alamatDefault' => $alamatDefault,
            'alamats' => $user->alamats,
        ]);
    }

    public function process(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_penerima' => 'required',
            'telepon_penerima' => 'required',
            'alamat_id' => 'required|exists:alamats,id',
            'ekspedisi' => 'required',
            'total' => 'required|numeric',
            'ongkir' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            $cart = Cart::with('items.produk')
                ->where('user_id', $user->id)
                ->firstOrFail();

            // VALIDASI STOK
            foreach ($cart->items as $item) {
                if ($item->produk->stok < $item->qty) {
                    throw new \Exception('Stok tidak cukup');
                }
            }

            // SIMPAN TRANSAKSI
            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'alamat_id' => $request->alamat_id,
                'nama_penerima' => $request->nama_penerima,
                'no_telp_penerima' => $request->telepon_penerima,
                'ekspedisi' => $request->ekspedisi,
                'tanggal_transaksi' => now(),
                'ongkir' => $request->ongkir,
                'total_harga' => $request->total,
                'status' => 'pending',
            ]);

            foreach ($cart->items as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->qty,
                    'harga_satuan' => $item->harga,
                    'subtotal' => $item->harga * $item->qty,
                ]);

                $item->produk->decrement('stok', $item->qty);
            }

            // MIDTRANS
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = false;

            $orderId = 'ORDER-' . $transaksi->id . '-' . time();

            $snapToken = \Midtrans\Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $request->total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ]);

            $transaksi->update([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);

            $cart->items()->delete();

            DB::commit();

            Notif::create([
                'user_id' => Auth::user()->id,
                'tanggal' => now(),
                'notifikasi' => 'Pesanan anda dengan kode ' . $transaksi->id . 'berhasil di buat pada ' . now(),
                'status' => 'belum_dibaca',
            ]);

            return response()->json([
                'snap_token' => $snapToken,
                'transaksi_id' => $transaksi->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function success($id)
    {

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'dikemas';
        $transaksi->no_resi = $transaksi->ekspedisi . $transaksi->id . time();
        $transaksi->save();
        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'Pesanan ' . $transaksi->id . 'telah berhasil di bayar pada ' . now(),
            'status' => 'belum_dibaca',
        ]);
        return view('checkout.success', compact('transaksi'));
    }

    public function pending($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('checkout.success', compact('transaksi'));
    }

    public function failed($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'Pesanan ' . $transaksi->id . 'Gagal di proses ',
            'status' => 'belum_dibaca',
        ]);
        return view('checkout.failed', compact('transaksi'));
    }

    public function alamatStore(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'label' => 'required|string|max:100',
            'nama_penerima' => 'required|string|max:255',
            'telepon_penerima' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string|max:500',
            'kota' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:10',
            'is_default' => 'nullable|boolean',
        ]);

        if ($request->is_default) {
            // reset alamat default lama
            $user->alamats()->update(['is_default' => false]);
        }

        /** @var Alamat $alamat */
        $alamat = new Alamat($request->all());
        $alamat->user_id = $user->id;
        $alamat->save();

        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'Anda berhasil menambah alamat baru di ' . $alamat->alamat,
            'status' => 'belum_dibaca',
        ]);

        return redirect()->route('checkout.index')->with('success', 'Alamat berhasil ditambahkan!');
    }
}
