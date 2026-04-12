@extends('layouts.app')

@section('content')
    {{ secure_route('home') }}
    <bt />
    {{ config('app.url') }}
    <h2>Selamat Datang</h2>

    <p style="text-align:center; margin-bottom: 25px;">
        Silakan masuk atau buat akun untuk melanjutkan.
    </p>

    <div style="margin-bottom: 15px;">
        <a href="{{ secure_route('login') }}">Sign In</a>
    </div>

    <div>
        <a href="{{ secure_route('register') }}">Sign Up</a>
    </div>
@endsection
