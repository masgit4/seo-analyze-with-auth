<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SEO Analyzer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="bg-gray-800 w-full max-w-2xl p-8 rounded-2xl shadow-lg">

        <!-- Title -->
        <h1 class="text-3xl font-bold text-center mb-2">
            🚀 SEO Analyzer
        </h1>
        <p class="text-center text-gray-400 mb-6">Welcome, <strong>{{ auth()->user()->name }}</strong></p>
        <p class="text-center text-gray-400 mb-6">
            Analyze your website SEO performance instantly
        </p>

        <!-- Error -->
        @if(session('error'))
            <div class="bg-red-500 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="/analyze" id="form" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 text-sm">Website URL</label>
                <input 
                    type="text" 
                    name="url" 
                    placeholder="https://example.com"
                    class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                    required
                >
            </div>

            <div>
                <label class="block mb-1 text-sm">Keyword (optional)</label>
                <input 
                    type="text" 
                    name="keyword" 
                    placeholder="e.g jasa website"
                    class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-green-500 hover:bg-green-600 p-3 rounded-lg font-semibold transition"
            >
                Analyze Website
            </button>
        </form>

        <p>Sisa limit hari ini: {{ $remaining }}</p>
        <div class="text-center text-gray-400 mb-4">
            Limit hari ini: {{ auth()->user()->limit }}x
            <br />
            Status:
            @if(auth()->user()->is_premium)
                <span class="text-green-400">Premium</span>
            @else
                <span class="text-yellow-400">Free</span>
            @endif
        </div>

        <a href="/history" class="block text-center mt-4 text-blue-400">
            View History >
        </a>

        <!-- Loading -->
        <div id="loading" class="hidden text-center mt-4 text-gray-300">
            ⏳ Analyzing website...
        </div>

        <div style="margin-top: 20px;">
            <a href="{{ secure_route('profile.show', auth()->user()->username) }}">
                <button
                    type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 p-3 rounded-lg font-semibold transition"
                >
                    View Profile
                </button>
            </a>
        </div>

        <form action="{{ secure_route('logout') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button
                type="submit"
                class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-lg font-semibold transition"
            >
                Sign Out
            </button>
        </form>

    </div>
</div>

<script>
document.getElementById("form").addEventListener("submit", function() {
    document.getElementById("loading").classList.remove("hidden");
});
</script>

</body>
</html>