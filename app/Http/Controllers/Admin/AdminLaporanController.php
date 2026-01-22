<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Kontrakan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{

    public function index()
    {
        $laporans = Laporan::with(['user', 'kontrakan'])
            ->latest()
            ->get();

        return view('admin.laporan', compact('laporans'));
    }

    /**
     * Hapus kontrakan dari laporan
     */
    public function hapusKontrakan($id)
    {
        $kontrakan = Kontrakan::findOrFail($id);
        $kontrakan->delete();

        return redirect()
            ->back()
            ->with('success', 'Kontrakan berhasil dihapus');
    }

    /**
     * Blokir user pelapor / pemilik kontrakan
     */
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = true;
        $user->save();

        return redirect()
            ->back()
            ->with('success', 'User berhasil diblokir');
    }
}
