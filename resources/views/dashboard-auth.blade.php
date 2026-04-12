@extends('layouts.app')

@section('content')
                <p class="text-center text-gray-400 mb-6">Welcome, <strong>{{ auth()->user()->name }}</strong></p>
                <p class="text-center text-gray-400 mb-6">
                    Analyze your website SEO performance instantly
                </p>
@if(session('error'))
                    <div class="bg-red-500 p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
@endif
                <form method="POST" action="{{ secure_route('analysis') }}" id="form" class="space-y-4">
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
                            placeholder="e.g website services"
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
                <p>Remaining limit today: {{ $remaining }}</p>
                <div class="text-center text-gray-400 mb-4">
                    Today's limit: {{ auth()->user()->limit }}x
                    <br />
                    Status:
@if(auth()->user()->is_premium)
                        <span class="text-green-400">Premium</span>
@else
                        <span class="text-yellow-400">Free</span>
@endif
                </div>
                <a
                    href="{{ secure_route('history') }}"
                    class="flex items-center justify-center mt-4 bg-yellow-400 font-semibold text-black p-3 rounded-lg"
                >
                    View History >
                </a>
                <div id="loading" class="hidden text-center mt-4 text-gray-300">
                    ⏳ Analyzing website...
                </div>
                <div class="mt-6">
                    <a
                        href="{{ secure_route('profile.show', auth()->user()->username) }}"
                        class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 p-3 rounded-lg font-semibold transition"
                    >
                        <button type="submit">
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
@endsection

@section('script')
            document.getElementById("form").addEventListener("submit", function() {
                document.getElementById("loading").classList.remove("hidden");
            });
@endsection
