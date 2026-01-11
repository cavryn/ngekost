<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show() {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit() {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request) {
        $request->validate([
            'name'  => 'required|max:255',
            'phone' => 'nullable|max:20',
            'bio'   => 'nullable|max:500',
        ]);

        $user = Auth::user();
        $user->update($request->only('name', 'phone', 'bio'));

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePhoto(Request $request) {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();

        if ($user->photo) {
            Storage::delete('public/profile/'.$user->photo);
        }

        $filename = time().'.'.$request->photo->extension();
        $request->photo->storeAs('public/profile', $filename);

        $user->photo = $filename;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Foto profil diperbarui!');
    }
}
