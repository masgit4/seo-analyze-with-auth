@extends('layouts.app')

@section('content')
                <h2 class="text-2xl font-bold text-center mb-2">Profile User</h2>
                <div class="mb-6">
                    <a href="{{ secure_route('profile.show', $user->username) }}">← Back to Profile</a>
                </div>
                <form action="{{ secure_route('profile.update', $user->username) }}" method="POST">
                    @csrf

                    @method('PUT')

                    <label>Nama</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    />
                    <label>Username</label>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username', $user->username) }}"
                        class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    />
                    <p class="text-center text-gray-400 mb-6">
                        Minimum 8 characters, only ;etters, numbers, dashes and underscores.
                    </p>
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    />
                    <button
                        type="submit"
                        class="w-full mt-6 mb-6 bg-green-500 hover:bg-green-600 p-3 rounded-lg font-semibold transition"
                    >
                        Simpan Perubahan Profile
                    </button>
                </form>

                <div style="margin-top: 20px;">
                    <a href="{{ secure_route('profile.password.edit', $user->username) }}">Ganti Password</a>
                </div>
@endsection