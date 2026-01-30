<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TarikController;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



// ─── Halaman Utama ───
Route::get('/', function () {
    return view('index');
});

// ─── Auth ───
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Dashboard ───
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return view('index', compact('user'));
    })->name('dashboard');
});

// ─── Katalog & Produk ───
Route::get('/katalog', [ProdukController::class, 'katalog'])->name('katalog');
Route::get('/produk/{id}', [ProdukController::class, 'detail'])->name('produk.detail');

//Laporan

    Route::get('/laporan/transaksi/cetak', [LaporanController::class, 'cetak'])
        ->name('laporan.transaksi.cetak');

// ─── Profile & Alamat ───
Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Alamat
    Route::get('/alamat/tambah', [ProfileController::class, 'alamatTambah'])->name('profile.alamatTambah');
    Route::post('/alamat/store', [ProfileController::class, 'alamatStore'])->name('profile.alamatStore');
    Route::get('/alamat/{id}/edit', [ProfileController::class, 'alamatEdit'])->name('profile.alamatEdit');
    Route::put('/alamat/{id}/update', [ProfileController::class, 'alamatUpdate'])->name('profile.alamatUpdate');
    Route::delete('/alamat/{id}/delete', [ProfileController::class, 'alamatDelete'])->name('profile.alamatDelete');

    // keranjang 

    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [CartController::class, 'add'])->name('keranjang.tambah');
    Route::post('/keranjang/update/{id}', [CartController::class, 'updateQty'])->name('keranjang.updateQty');
    Route::delete('/keranjang/hapus/{id}', [CartController::class, 'remove'])->name('keranjang.remove');

    //Co 
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::post('/checkout/alamat', [CheckoutController::class, 'alamatStore'])->name('checkout.alamatStore');




    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/pending/{id}', [CheckoutController::class, 'pending'])->name('checkout.pending');
    Route::get('/checkout/failed/{id}', [CheckoutController::class, 'failed'])->name('checkout.failed');


    //Pesanan Saya
    Route::get('/pesanan-saya', [PesananController::class, 'index'])->name('pesanan.saya');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.detail');
    Route::post('/pesanan/{id}/batal/', [PesananController::class, 'batal'])->name('pesanan.batal');
    Route::post('/pesanan/{id}/diterima', [PesananController::class, 'diterima'])->name('pesanan.diterima');
    Route::get('/pesanan/{id}/return', [PesananController::class, 'returnForm'])
        ->name('pesanan.return.form');

    Route::post('/pesanan/{id}/return', [PesananController::class, 'returnStore'])
        ->name('pesanan.return.store');


    //Laporan

    Route::get('/laporan/transaksi/cetak', [LaporanController::class, 'cetak'])
        ->name('laporan.transaksi.cetak');

    //Tarik

    Route::get('/tarik', [TarikController::class, 'index'])->name('tarik');
    Route::post('/tarik/baru', [TarikController::class, 'baru'])->name('tarik.baru');
    Route::get('/tarik/struk/{id}', [TarikController::class, 'struk'])->name('tarik.struk');

    //Riview
    Route::post('/review', [ProdukController::class, 'riview'])->name('review');
});
