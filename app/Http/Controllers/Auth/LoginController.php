<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function form()
    {
        return view('auth.login');
    }

    public function storeWithSession(Request $request, AuthService $authService)
    {
        $authService->attemptLogin($request);

        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Login success');
    }

    public function storeOnce(Request $request, AuthService $authService)
    {
        $user = $authService->attemptLogin($request);

        $device = $request->input('device', 'mobile');

        return response()->json([
            'message' => 'Login success.',
            'token' => $user->createToken($device)->plainTextToken,
            'user' => $user,
        ]);
    }
}
