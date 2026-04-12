@extends('layouts.app')

@section('content')
    <h2>Sign Up</h2>

    <form action="{{ secure_route('register.post') }}" method="POST">
        @csrf

        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label>Username</label>
        <input type="text" name="username" value="{{ old('username') }}" required>
        <small>Minimal 6 karakter. Hanya huruf, angka, strip, dan underscore</small>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Daftar</button>
    </form>

    <p style="margin-top: 16px; text-align:center;">
        Sudah punya akun?
        <a href="{{ secure_route('login') }}" style="background:none; color:#0d6efd; padding:0; width:auto;">Sign In</a>
    </p>
@endsection
