<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DeleteController extends Controller
{
    public function form(Request $request, $username)
    {
        $user = $request->user();

        if ($user->username !== $username) {
            abort(403, 'Kamu tidak diizinkan mengakses halaman ini.');
        }

        return view('profile.delete', compact('user'));
    }

    public function storeWithSession(Request $request, $username)
    {
        $user = $request->user();

        if ($user->username !== $username) {
            abort(403, 'Kamu tidak diizinkan menghapus akun ini.');
        }

        $validated = $request->validate([
            'password' => ['required'],
        ]);

        if (!Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'Password tidak sesuai.',
            ]);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Akun berhasil dihapus secara permanen.');
    }

    public function storeOnce(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'password' => ['required'],
        ]);

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Password salah.',
                'errors' => [
                    'password' => ['Password salah.']
                ]
            ], 422);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'message' => 'Akun berhasil dihapus.',
        ]);
    }
}
