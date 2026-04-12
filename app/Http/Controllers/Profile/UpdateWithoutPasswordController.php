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
            abort(403, "You're not allowed to edit this profile.");
        }

        return view('profile.edit', compact('user'));
    }

    public function storeWithSession(Request $request, AuthService $authService, $username)
    {
        $user = $request->user();

        if ($user->username !== $username) {
            abort(403, "You're not allowed to edit this profile.");
        }

        $oldUsername = $user->username;

        $authService->attemptUpdateWithoutPassword($request, $user);

        if ($oldUsername !== $user->username) {
            return redirect()->route('profile.edit', $user->username)
                ->with('success', 'Profile has been successfully, username has also been updated.');
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function storeOnce(Request $request, AuthService $authService)
    {
        $user = $request->user();

        $authService->attemptUpdateWithoutPassword($request, $user);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user->fresh(),
        ]);
    }
}
