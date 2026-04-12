@extends('layouts.app')

@section('content')
    <h2>Sign In</h2>

    <form action="{{ secure_route('login.post') }}" method="POST">
        @csrf

        <label>Email atau Username</label>
        <input type="text" name="login" value="{{ old('login') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Masuk</button>
    </form>

    <p style="margin-top: 16px; text-align:center;">
        Belum punya akun?
        <a href="{{ secure_route('register') }}" style="background:none; color:#0d6efd; padding:0; width:auto;">Sign Up</a>
    </p>
@endsection
