<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontrakan;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // TAMPILKAN FORM LAPORAN
    public function create($id)
    {
        $kontrakan = Kontrakan::findOrFail($id);

        return view('laporan.create', compact('kontrakan'));
    }

    // SIMPAN LAPORAN
    public function store(Request $request)
    {
        $request->validate([
            'kontrakan_id' => 'required|exists:kontrakans,id',
            'alasan' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        Laporan::create([
            'user_id' => Auth::id(),
            'kontrakan_id' => $request->kontrakan_id,
            'alasan' => $request->alasan,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Laporan berhasil dikirim');
    }
}
