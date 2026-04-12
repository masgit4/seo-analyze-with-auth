@extends('layouts.app')

@section('content')
                <p class="text-center text-gray-400 mb-6">Welcome</p>
                <p class="text-center text-gray-400 mb-6">Please login or create an account to continue.</p>
                <div class="flex justify-between items-center">
                    <a
                        class="w-full bg-blue-500 hover:bg-blue-600 p-3 rounded-lg font-semibold transition text-center"
                        href="{{ secure_route('login') }}"
                    >
                        Sign In
                    </a>
                </div>
                <br/>
                <div class="flex justify-between items-center">
                    <a
                        class="w-full bg-green-500 hover:bg-green-600 p-3 rounded-lg font-semibold transition text-center"
                        href="{{ secure_route('register') }}"
                    >
                        Sign Up
                    </a>
                </div>
@endsection
