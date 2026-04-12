<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateOnlyPasswordController extends Controller
{
    public function form(Request $request, $username)
    {
        $user = $request->user();

        if ($user->username !== $username) {
            abort(403, 'Kamu tidak diizinkan mengakses halaman ini.');
        }

        return view('profile.password', compact('user'));
    }

    public function storeWithSession(Request $request, AuthService $authService, $username)
    {
        $user = $request->user();

        if ($user->username !== $username) {
            abort(403, 'Kamu tidak diizinkan mengubah password akun ini.');
        }

        $service = $authService->attemptUpdateOnlyPassword($request, $user, function ($request) {
            $request->session()->regenerate();

            return back()->with('success', 'Password berhasil diganti.');
        });

        if (!$service['has']) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        return $service['update'];
    }

    public function storeOnce(Request $request, AuthService $authService)
    {
        $user = $request->user();

        $service = $authService->attemptUpdateOnlyPassword($request, $user, function () {
            return response()->json([
                'message' => 'Password berhasil diubah.',
            ]);
        });

        if (!$service['has']) {
            return response()->json([
                'message' => 'Password lama salah.',
                'errors' => [
                    'current_password' => ['Password lama salah.']
                ]
            ], 422);
        }

        return $service['update'];
    }
}
