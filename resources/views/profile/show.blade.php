@extends('layouts.app')

@section('content')
                <h2 class="text-2xl font-bold text-center mb-2">Profile User</h2>
                <p class="mt-1 mb-1"><strong>Nama:</strong> {{ $user->name }}</p>
                <p class="mt-1 mb-1"><strong>Username:</strong> {{ $user->username }}</p>
                <p class="mt-1 mb-1"><strong>Email:</strong> {{ $user->email }}</p>
@auth
@if(auth()->user()->id === $user->id)
                <div class="mt-6">
                    <a href="{{ secure_route('home') }}">Home</a>
                </div>
                <div class="mt-6">
                    <a href="{{ secure_route('profile.edit', $user->username) }}">Edit Profile</a>
                </div>
                <div class="mt-6">
                    <a href="{{ secure_route('profile.password.edit', $user->username) }}">Ganti Password</a>
                </div>
                <div class="mt-6">
                    <a href="{{ secure_route('profile.delete.form', $user->username) }}" class="btn-danger-link">Delete Account</a>
                </div>
                <form action="{{ secure_route('logout') }}" method="POST" style="margin-top: 20px;">
@csrf
                    <button
                        type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-lg font-semibold transition"
                    >
                        Sign Out
                    </button>
                </form>

@endif
@endauth
@endsection