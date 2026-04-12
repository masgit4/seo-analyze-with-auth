@extends('layouts.app')

@section('content')
    <h2>Dashboard</h2>

    <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong></p>
    <p>Username: {{ auth()->user()->username }}</p>
    <p>Email: {{ auth()->user()->email }}</p>

    <div style="margin-top: 20px;">
        <a href="{{ secure_route('profile.show', auth()->user()->username) }}">Lihat Profile</a>
    </div>

    <form action="{{ secure_route('logout') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <button type="submit">Sign Out</button>
    </form>
@endsection