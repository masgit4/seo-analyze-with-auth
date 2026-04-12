<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MasgitDemoWeb - Auth CRUD & SEO Analyzer</title>
        <link rel="stylesheet" href="{{ url('/css/style.css') }}">
        <script src="https://cdn.tailwindcss.com"></script>
@if (View::hasSection('head'))
@yield('head')
@endif
    </head>
    <body class="bg-gray-900 text-white">
@if (View::hasSection('content'))
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="bg-gray-800 w-full max-w-2xl p-8 rounded-2xl shadow-lg">
                <h1 class="text-3xl font-bold text-center mb-2">🚀 MasgitDemoWeb</h1>
                <h1 class="text-3xl font-bold text-center mb-2">Auth CRUD & SEO Analyzer</h1>
@if(session('success'))
                <div class="mb-2 mt-2 flex items-center justify-center bg-blue-300 p-3 rounded-lg text-black transition">
                    {{ session('success') }}
                </div>
@endif
@if($errors->any())
                <div class="mb-2 mt-2 flex items-center justify-center bg-red-300 p-3 rounded-lg text-black transition">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
@endif
@yield('content')
            </div>
        </div>
@endif
@if (View::hasSection('body'))
@yield('body')
@endif
@if (View::hasSection('script'))
        <script>
@yield('script')
        </script>
@endif
    </body>
</html>
