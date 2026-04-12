<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateWithoutPasswordController extends Controller
{
    public function form(Request $request, $username)
    {
        $user = $request->user();

        if ($user->username !== $username) {
            abort(403, 'Kamu tidak diizinkan mengedit profile ini.');
        }

        return view('profile.edit', compact('user'));
    }

    public function storeWithSession(Request $request, AuthService $authService, $username)
    {
        $user = $request->user();

        if ($user->username !== $username) {
            abort(403, 'Kamu tidak diizinkan mengedit profile ini.');
        }

        $oldUsername = $user->username;

        $authService->attemptUpdateWithoutPassword($request, $user);

        if ($oldUsername !== $user->username) {
            return redirect()->route('profile.edit', $user->username)
                ->with('success', 'Profile berhasil diperbarui. Username juga sudah diperbarui.');
        }

        return back()->with('success', 'Profile berhasil diperbarui.');
    }

    public function storeOnce(Request $request, AuthService $authService)
    {
        $user = $request->user();

        $authService->attemptUpdateWithoutPassword($request, $user);

        return response()->json([
            'message' => 'Profile berhasil diperbarui.',
            'user' => $user->fresh(),
        ]);
    }
}
