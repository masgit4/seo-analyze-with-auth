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
            abort(403, "You're not permitted to access this page.");
        }

        return view('profile.delete', compact('user'));
    }

    public function storeWithSession(Request $request, $username)
    {
        $user = $request->user();

        if ($user->username !== $username) {
            abort(403, "You're not allowed to delete this account.");
        }

        $validated = $request->validate([
            'password' => ['required'],
        ]);

        if (!Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'password' => "Password doesn't match.",
            ]);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Account has been successfully deleted permanently.');
    }

    public function storeOnce(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'password' => ['required'],
        ]);

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => "Password doesn't match.",
                'errors' => [
                    'password' => ['Wrong password.']
                ]
            ], 422);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'message' => 'Account has been successfully deleted permanently.',
        ]);
    }
}
