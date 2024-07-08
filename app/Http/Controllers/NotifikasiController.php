<?php

namespace App\Http\Controllers;

use App\Models\notifikasi;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $notifikasis = notifikasi::paginate($perPage);

        return view('pages.notifikasi', compact('notifikasis'));
    }

    public function create()
    {
        return view('crud.notifikasicreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'isi' => 'required|string',
            'email' => 'required|string',
        ]);
        $cekuser=User::where('email',$request->email)->first();
        if(!$cekuser){
            return back()->with('eror','user tidak ada');
        }

        Notifikasi::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'user_id' => $cekuser->id,
        ]);
        return redirect()->route('notifikasi.index')->with('success', 'notifikasi berhasil dikirimkan');
    }

    public function show(notifikasi $notifikasi)
    {
        return view('crud.notifikasishow', compact('notifikasi'));
    }

    public function edit(notifikasi $notifikasi)
    {
        return view('crud.notifikasiedit', compact('notifikasi'));
    }

    public function update(Request $request, notifikasi $notifikasi)
    {
        $request->validate([
            'judul' => 'required|string',
            'isi' => 'required|string',
            /* 'user_id' => 'required|string', */
        ]);

        $notifikasi->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'penerima_id' => Auth::id(),
        ]);
        return redirect()->route('notifikasi.index')->with('success', 'notifikasi berhasil diperbarui');
    }

    public function destroy(notifikasi $notifikasi)
    {
        $notifikasi->delete();
        return redirect()->route('notifikasi.index')->with('success', 'notifikasi berhasil dihapus');
    }
}
