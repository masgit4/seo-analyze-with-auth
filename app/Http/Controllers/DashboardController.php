<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexPage()
    {
        if (auth()->check()) {
            $used = Analysis::where('user_id', auth()->id())
                ->whereDate('created_at', today())->count();

            $remaining = auth()->user()->limit - $used;

            return view('dashboard', compact('remaining'));
        }

        return view('home-guest');

    }

    public function profilePage($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return view('profile.show', compact('user'));
    }

    public function apiProfile(Request $request)
    {
        return response()->json($request->user());
    }

    public function apiOnlyUserProfile($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return response()->json([
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'bio' => $user->bio,
            'created_at' => $user->created_at,
        ]);
    }
}
