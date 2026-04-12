@extends('layouts.app')

@section('content')
    <h2>Profile User</h2>

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Username:</strong> {{ $user->username }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    @auth
        @if(auth()->user()->id === $user->id)
            <div style="margin-top: 20px;">
                <a href="{{ route('profile.edit', $user->username) }}">Edit Profile</a>
            </div>

            <div style="margin-top: 12px;">
                <a href="{{ route('profile.password.edit', $user->username) }}">Ganti Password</a>
            </div>

            <div style="margin-top: 12px;">
                <a href="{{ route('profile.delete.form', $user->username) }}" class="btn-danger-link">Delete Account</a>
            </div>
        @endif
    @endauth
@endsection