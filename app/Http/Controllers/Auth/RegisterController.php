<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function form()
    {
        return view('auth.register');
    }

    public function storeWithSession(Request $request, AuthService $authService)
    {
        Auth::login($authService->attemptRegister($request));

        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Registrasi berhasil, kamu sudah login.');
    }

    public function storeOnce(Request $request, AuthService $authService)
    {
        $user = $authService->attemptRegister($request);

        $token = $user->createToken('mobile-token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil.',
            'token' => $token,
            'user' => $user,
        ], 201);
    }
}
