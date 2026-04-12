@extends('layouts.app')

@section('content')
                <h2 class="text-2xl font-bold text-center mb-2">Sign In</h2>
                <form action="{{ secure_route('register.post') }}" method="POST">
                    @csrf

                    <label>Your Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    />
                    <label>Username</label>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
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
                        value="{{ old('email') }}"
                        class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    />
                    <label>Password</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    />
                    <label>Confirm Password</label>
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
                        Sign Up
                    </button>
                </form>
                <p class="text-center">
                    Already have an account?
                    <a
                        class="w-full mt-2 bg-blue-500 hover:bg-blue-600 p-3 rounded-lg font-semibold transition"
                        href="{{ secure_route('register') }}"
                    >
                        Sign In
                    </a>
                </p>
@endsection
