<?php 
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id; 

        $cart = Cart::firstOrCreate(['user_id' => $userId]);
        $items = $cart->items()->with('produk')->get();

        return view('cart.index', compact('cart', 'items'));
    }

    public function add(Request $request, $produk_id)
{
    // Cek user login
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login dulu untuk menambahkan produk ke keranjang.');
    }

    $userId = Auth::id(); 

    // Ambil produk, jika tidak ada otomatis 404
    $produk = Produk::findOrFail($produk_id);

    // Ambil atau buat cart user
    $cart = Cart::firstOrCreate(['user_id' => $userId]);

    // Cek apakah item sudah ada di cart
    $item = CartItem::where('cart_id', $cart->id)
        ->where('produk_id', $produk_id)
        ->first();

    $qty = $request->qty ?? 1; // jika qty tidak diisi, default 1
    

    if ($item) {
        $item->qty += $qty;
        $item->save();
    } else {
        CartItem::create([
            'cart_id' => $cart->id,
            'produk_id' => $produk_id,
            'qty' => $qty,
            'harga' => $produk->harga_jual,
        ]);
    }

    return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
}


    public function updateQty(Request $request, $id)
{
    $request->validate([
        'qty' => 'required|integer|min:1'
    ]);

    $item = CartItem::findOrFail($id);
    $item->qty = $request->qty;
    $item->save();

    return back();
}


    public function remove($item_id)
    {
        CartItem::destroy($item_id);
        return redirect()->back()->with('success', 'Item dihapus dari keranjang');
    }
}
