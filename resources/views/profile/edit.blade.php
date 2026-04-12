@extends('layouts.app')

@section('content')
    <h2>Edit Profile</h2>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('profile.show', $user->username) }}">← Kembali ke Profile</a>
    </div>

    <form action="{{ route('profile.update', $user->username) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

        <label>Username</label>
        <input type="text" name="username" value="{{ old('username', $user->username) }}" required>
        <small>Minimal 6 karakter. Hanya huruf, angka, strip, dan underscore</small>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

        <button type="submit">Simpan Perubahan Profile</button>
    </form>

    <div style="margin-top: 20px;">
        <a href="{{ route('profile.password.edit', $user->username) }}">Ganti Password</a>
    </div>
@endsection