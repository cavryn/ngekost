<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontrakan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KontrakanController extends Controller
{
    public function index()
    {
        $kontrakans = Kontrakan::where('user_id', Auth::id())->get();
        return view('kontrakan.manage', compact('kontrakans'));
    }

    public function edit($id)
    {
        $kontrakan = Kontrakan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('kontrakan.edit', compact('kontrakan'));
    }

    public function update(Request $request, $id)
    {
        $kontrakan = Kontrakan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'judul' => 'required',
            'harga' => 'required|numeric',
            'jumlah_penghuni' => 'required|numeric|min:0',
            'foto' => 'nullable|image'
        ]);

        if ($request->jumlah_penghuni > $kontrakan->max_penghuni) {
            return back()->with('error', 'Jumlah penghuni melebihi kapasitas!');
        }

        if ($request->hasFile('foto')) {
            if ($kontrakan->foto) {
                Storage::delete('public/kontrakan/' . $kontrakan->foto);
            }

            $foto = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/kontrakan', $foto);
            $kontrakan->foto = $foto;
        }

        $kontrakan->update([
            'judul' => $request->judul,
            'harga' => $request->harga,
            'jumlah_penghuni' => $request->jumlah_penghuni,
            'foto' => $kontrakan->foto
        ]);

        return redirect()->route('kontrakan.index')
            ->with('success', 'Kontrakan berhasil diperbarui');
    }


    public function show($id)
    {
        $kontrakan = Kontrakan::findOrFail($id);
        return view('kontrakan.show', compact('kontrakan'));
    }

    public function create()
{
    return view('kontrakan.create');
}

public function store(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'alamat' => 'required',
        'harga' => 'required|numeric',
        'max_penghuni' => 'required|numeric|min:1',
        'jumlah_penghuni' => 'nullable|numeric|min:0',
        'latitude' => 'nullable',
        'longitude' => 'nullable',
        'foto' => 'nullable|image'
    ]);

    $foto = null;

    if ($request->hasFile('foto')) {
        $foto = time() . '.' . $request->foto->extension();
        $request->foto->storeAs('public/kontrakan', $foto);
    }

    Kontrakan::create([
        'user_id' => Auth::id(),
        'judul' => $request->judul,
        'alamat' => $request->alamat,
        'harga' => $request->harga,
        'deskripsi' => $request->deskripsi,
        'max_penghuni' => $request->max_penghuni,
        'jumlah_penghuni' => $request->jumlah_penghuni ?? 0,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'foto' => $foto,
    ]);

    return redirect()->route('dashboard')
        ->with('success', 'Kontrakan berhasil ditambahkan');
}


}
