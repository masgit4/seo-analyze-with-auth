@extends('layouts.app')

@section('content')
    <h2>Ganti Password</h2>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('profile.show', $user->username) }}">← Kembali ke Profile</a>
    </div>

    <form action="{{ route('profile.password.update', $user->username) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Password Lama</label>
        <input type="password" name="current_password" required>

        <label>Password Baru</label>
        <input type="password" name="password" required>

        <label>Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Ganti Password</button>
    </form>
@endsection