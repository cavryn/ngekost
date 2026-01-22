<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileApiController extends Controller
{
    // GET /api/profile
    public function show()
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }

    // POST /api/profile
    public function update(Request $request)
    {
        $request->validate([
            'usia'           => 'nullable|integer|min:15|max:100',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'domisili'       => 'nullable|string|max:100',
            'deskripsi_diri' => 'nullable|string|max:500',
        ]);

        $profile = Profile::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only([
                'usia',
                'jenis_kelamin',
                'domisili',
                'deskripsi_diri'
            ])
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diperbarui',
            'data' => $profile
        ]);
    }
}
