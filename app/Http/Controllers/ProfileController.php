<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alamat;
use App\Models\Notif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProfileController extends Controller
{
    use AuthorizesRequests;

    /**
     * Tampilkan profil user beserta alamat
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->load('alamats'); // relasi User->alamats()
        return view('profile.index', compact('user'));
    }

    /**
     * Form edit profil
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update data profil
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,


        ];

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $user->id . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('public/storage/users', $filename); // simpan di storage/app/public/users
            $data['foto'] = 'users/' . $filename; // path untuk database (sesuai asset/storage)
        }

        $user->update($data);
        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'almat berhasil di perbarui',
            'status' => 'belum_dibaca',
        ]);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }


    /**
     * Form tambah alamat
     */
    public function alamatTambah()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('profile.alamatTambah', compact('user'));
    }

    /**
     * Simpan alamat baru
     */
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
            'notifikasi' => 'penambahan alamat berhasil',
            'status' => 'belum_dibaca',
        ]);

        return redirect()->route('profile')->with('success', 'Alamat berhasil ditambahkan!');
    }

    /**
     * Form edit alamat
     */
    public function alamatEdit($id)
    {
        /** @var Alamat $alamat */
        $alamat = Alamat::findOrFail($id);
        $this->authorize('update', $alamat);

        return view('profile.alamatEdit', compact('alamat'));
    }

    /**
     * Update alamat
     */
    public function alamatUpdate(Request $request, $id)
    {
        /** @var Alamat $alamat */
        $alamat = Alamat::findOrFail($id);
        $this->authorize('update', $alamat);

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
            /** @var User $user */
            $user = $alamat->user;
            $user->alamats()->update(['is_default' => false]);
        }

        $alamat->update($request->all());
        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'alamat berhasil di perbarui',
            'status' => 'belum_dibaca',
        ]);


        return redirect()->route('profile')->with('success', 'Alamat berhasil diperbarui!');
    }

    /**
     * Hapus alamat
     */
    public function alamatDelete(Alamat $alamat)
    {
        $this->authorize('delete', $alamat);
        $alamat->delete();
        Notif::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now(),
            'notifikasi' => 'almat berhasil di hapus',
            'status' => 'belum_dibaca',
        ]);


        return redirect()->route('profile')->with('success', 'Alamat berhasil dihapus!');
    }
}
