<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * GET /profile
     */
    public function index()
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        return view('profile.index', compact('profile'));
    }

    /**
     * POST /profile
     */
public function update(Request $request)
{
    $request->validate([
        'usia'           => 'nullable|integer|min:15|max:100',
        'jenis_kelamin'  => 'nullable|in:L,P',
        'domisili'       => 'nullable|string|max:100',
        'deskripsi_diri' => 'nullable|string|max:500',
        'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $profile = Profile::firstOrCreate(
        ['user_id' => Auth::id()]
    );

if ($request->hasFile('foto')) {
    $filename = time().'.'.$request->foto->extension();
    $request->foto->storeAs('profile', $filename, 'public');
    $profile->foto = $filename;
}


    $profile->update($request->only([
        'usia',
        'jenis_kelamin',
        'domisili',
        'deskripsi_diri',
    ]));

    return redirect()->back()->with('success', 'Profile berhasil diperbarui');
}

}
