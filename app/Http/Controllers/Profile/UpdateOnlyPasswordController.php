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
            abort(403, "You're not permitted to access this page.");
        }

        return view('profile.password', compact('user'));
    }

    public function storeWithSession(Request $request, AuthService $authService, $username)
    {
        $user = $request->user();

        if ($user->username !== $username) {
            abort(403, "You're not allowed to change the password for this account.");
        }

        $service = $authService->attemptUpdateOnlyPassword($request, $user, function ($request) {
            $request->session()->regenerate();

            return back()->with('success', 'Password changed successfully.');
        });

        if (!$service['has']) {
            return back()->withErrors([
                'current_password' => 'The old password is not suitable.',
            ]);
        }

        return $service['update'];
    }

    public function storeOnce(Request $request, AuthService $authService)
    {
        $user = $request->user();

        $service = $authService->attemptUpdateOnlyPassword($request, $user, function () {
            return response()->json([
                'message' => 'Password changed successfully.',
            ]);
        });

        if (!$service['has']) {
            return response()->json([
                'message' => 'Password lama salah.',
                'errors' => [
                    'current_password' => ['The old password is not suitable.']
                ]
            ], 422);
        }

        return $service['update'];
    }
}
