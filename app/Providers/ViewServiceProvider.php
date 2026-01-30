<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Notif;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {

            // ================= CART =================
            $cartCount = 0;

            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->first();

                if ($cart) {
                    $cartCount = $cart->items()->sum('qty');
                }
            }

            // ================= NOTIFIKASI =================
            $notifCount = 0;
            $notifikasi = collect();

            if (Auth::check()) {
                $notifCount = Notif::where('user_id', Auth::id())
                    ->where('status', 'belum_dibaca')
                    ->count();

                $notifikasi = Notif::where('user_id', Auth::id())
                    ->latest()
                    ->take(5)
                    ->get();
            }

            // ================= SHARE KE VIEW =================
            $view->with([
                'cartCount'  => $cartCount,
                'notifCount' => $notifCount,
                'notifikasi' => $notifikasi,
            ]);
        });
    }
}
