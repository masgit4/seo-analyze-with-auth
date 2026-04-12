@extends('layouts.app')

@section('content')
    <h2>Selamat Datang</h2>

    <p style="text-align:center; margin-bottom: 25px;">
        Silakan masuk atau buat akun untuk melanjutkan.
    </p>

    <div style="margin-bottom: 15px;">
        <a href="{{ route('login') }}">Sign In</a>
    </div>

    <div>
        <a href="{{ route('register') }}">Sign Up</a>
    </div>
@endsection