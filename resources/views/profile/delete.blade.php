@extends('layouts.app')

@section('content')
    <h2>Delete Account</h2>

    <div style="margin-bottom: 20px;">
        <a href="{{ secure_route('profile.show', $user->username) }}">← Kembali ke Profile</a>
    </div>

    <div class="alert-error" style="margin-bottom: 20px;">
        <strong>Peringatan:</strong> akun yang sudah dihapus tidak bisa dikembalikan.
    </div>

    <form action="{{ secure_route('profile.delete', $user->username) }}" method="POST">
        @csrf
        @method('DELETE')

        <label>Masukkan Password untuk Konfirmasi</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn-danger">Hapus Akun Permanen</button>
    </form>
@endsection