<?php
namespace App\Http\Controllers;

use App\Models\Notif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller{
    public function index(){
        $notif = Notif::where('user_id', Auth::user()->id)
        ->latest()
        ->paginate(10);

        return view('notif.index', compact($notif));

        
    }
}