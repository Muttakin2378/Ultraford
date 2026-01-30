<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPenarikan;
use App\Models\User;
use App\Models\Notif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use function Symfony\Component\Clock\now;

class TarikController extends Controller
{

    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();

        $riwayat = RiwayatPenarikan::where('user_id', $user->id)->latest()->get();
        return view('tarik.index', compact('user', 'riwayat'));
    }

    public function baru(Request $request)
    {

        $user = Auth::user();
        $penarikan = RiwayatPenarikan::create([
            'user_id' => $user->id,
            'tujuan' => $request->bank,
            'nominal' => $request->nominal,
            'rekening' => $request->norek,
            'kode_penarikan' => 'TARIK' . rand(),
            'tanggal_penarikan' => now(),
            'status' => 'Terkirim',

        ]);
        $penarikan->kode_penarikan = 'TARIK' . $penarikan->id . time();
        $penarikan->tanggal_final = now();
        $penarikan->save();
        $user->saldo = $user->saldo - $request->nominal;
        $user->save();
        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'Penarikan sebesar ' . $penarikan->nominal . ' telah berhasil',
            'status' => 'belum_dibaca',
        ]);

        return back()->with('success', 'Penarikan sukses');
    }

    public function struk($id)
    {
        $user = Auth::user();

        $penarikan = RiwayatPenarikan::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('tarik.struk', compact('penarikan', 'user'));
    }
}
