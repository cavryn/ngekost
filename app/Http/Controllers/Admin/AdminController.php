<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Kontrakan;
use App\Models\User;

class AdminController extends Controller
{
    public function laporan()
    {
        $laporans = Laporan::with(['user', 'kontrakan'])
            ->latest()
            ->get();

        return view('admin.laporan', compact('laporans'));
    }

    public function hapusKontrakan($id)
    {
        Kontrakan::findOrFail($id)->delete();
        return back()->with('success', 'Kontrakan dihapus');
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_blocked' => true]);

        return back()->with('success', 'User berhasil diblokir');
    }
}
