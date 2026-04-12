@extends('layouts.app')

@section('content')
                <h2 class="text-2xl font-bold text-center mb-2">Sign In</h2>
                <form action="{{ secure_route('login.post') }}" method="POST">
                    @csrf

                    <label>Email or Username</label>
                    <input
                        type="text"
                        name="login"
                        value="{{ old('login') }}"
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
                    <br />
                    <button
                        type="submit"
                        class="w-full mt-6 mb-6 bg-blue-500 hover:bg-blue-600 p-3 rounded-lg font-semibold transition"
                    >
                        Sign In
                    </button>
                </form>
                <p class="text-center">
                    Don't have an account yet?
                    <a
                        class="w-full mt-2 bg-green-500 hover:bg-green-600 p-3 rounded-lg font-semibold transition"
                        href="{{ secure_route('register') }}"
                    >
                        Sign Up
                    </a>
                </p>
@endsection
