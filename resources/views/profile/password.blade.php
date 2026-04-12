@extends('layouts.app')

@section('content')
                <h2 class="text-2xl font-bold text-center mb-2">Change Password</h2>
                <div class="mb-6">
                    <a href="{{ secure_route('profile.show', $user->username) }}">← Back to Profile</a>
                </div>
                <form action="{{ secure_route('profile.password.update', $user->username) }}" method="POST">
                    @csrf

                    @method('PUT')

                    <label>Old Password</label>
                    <input
                        type="password"
                        name="current_password"
                        class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    />
                    <label>New Password</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    />
                    <label>Confirm New Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    />
                    <button
                        type="submit"
                        class="w-full mt-6 mb-6 bg-green-500 hover:bg-green-600 p-3 rounded-lg font-semibold transition"
                    >
                        Ganti Password
                    </button>
                </form>
@endsection