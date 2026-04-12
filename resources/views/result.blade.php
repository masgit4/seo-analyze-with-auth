@extends('layouts.app')

@section('body')
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-center mt-6 mb-6">
                <h1 class="text-3xl font-bold m-0">📊 Analysis Result</h1>
                <a
                    href="{{ secure_route('export.pdf', ['id' => $analysis->id]) }}" 
                    class="max-w-max bg-purple-500 hover:bg-purple-600 px-4 py-2 rounded-lg mt-4 inline-block"
                >
                    📄 Download PDF
                </a>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-gray-800 p-5 rounded-xl shadow">
                    <h2 class="text-xl font-semibold mb-3 text-left">🌐 Website Info</h2>
                    <p><b>URL:</b> {{ $analysis->url }}</p>
                    <p><b>Title:</b> {{ $analysis->title }}</p>
                    <p><b>Description:</b> {{ $analysis->description }}</p>
                </div>
                <div class="bg-gray-800 p-5 rounded-xl shadow">
                    <h2 class="text-xl font-semibold mb-3 text-left">⚙️ Technical SEO</h2>
                    <p>HTTPS: {{ $analysis->https ? '✅ Yes' : '❌ No' }}</p>
                    <p>Sitemap: {{ $analysis->sitemap ? '✅ Found' : '❌ Not Found' }}</p>
                    <p>Robots.txt: {{ $analysis->robots ? '✅ Found' : '❌ Not Found' }}</p>
                    <p>Canonical: {{ $analysis->canonical ? '✅ Yes' : '❌ No' }}</p>
                    <p>Open Graph: {{ $analysis->og_tags ? '✅ Yes' : '❌ No' }}</p>
                </div>
                <div class="bg-gray-800 p-5 rounded-xl shadow">
                    <h2 class="text-xl font-semibold mb-3 text-left">📑 Page Structure</h2>
                    <p>H1: {{ $analysis->h1 }}</p>
                    <p>H2: {{ $analysis->h2 }}</p>
                    <p>Images without ALT: {{ $analysis->img_no_alt }}</p>
                </div>
                <div class="bg-gray-800 p-5 rounded-xl shadow">
                    <h2 class="text-xl font-semibold mb-3 text-left">🔗 Link Analysis</h2>
                    <p>Internal Links: {{ $analysis->internal_links }}</p>
                    <p>External Links: {{ $analysis->external_links }}</p>
                </div>
                <div class="bg-gray-800 p-5 rounded-xl shadow md:col-span-2">
                    <h2 class="text-xl font-semibold mb-3 text-left">🔍 Keyword Analysis</h2>
                    <p>Keyword Density: {{ number_format($analysis->keyword_density, 2) }}%</p>
                </div>
                <div class="bg-gray-800 p-5 rounded-xl shadow md:col-span-2">
                    <h2 class="text-xl font-semibold mb-4 text-left">🚀 SEO Score</h2>

                    <div class="w-full bg-gray-700 rounded-full h-6">
                        <div 
                            class="bg-green-500 h-6 rounded-full text-center text-sm font-semibold"
                            style="width: {{ $analysis->score }}%">
                            {{ $analysis->score }}/100
                        </div>
                    </div>
                </div>
@if ($withId !== true)
                <div class="bg-gray-800 p-5 rounded-xl shadow md:col-span-2">
                    <h2 class="text-xl font-semibold mb-4 text-left">🧠 SEO Recommendations</h2>
                    <ul class="space-y-2">
@foreach($recommendations as $rec)
                            <li class="
                                p-3 rounded-lg flex items-center gap-2
                            @if($rec['status'] == 'good') bg-green-500
                            @elseif($rec['status'] == 'warning') bg-yellow-500
                            @else bg-red-500
                            @endif ">
                                <span>
@if($rec['status'] == 'good')
                                    ✅
@elseif($rec['status'] == 'warning') ⚠️
@else
                                    ❌
@endif
                                </span>

                                <span>{{ $rec['text'] }}</span>
                            </li>
@endforeach
                    </ul>
                </div>
@endif
            </div>
            <div class="mt-6 mb-6">
                <a href="{{ secure_route('home') }}" class="bg-blue-500 hover:bg-blue-600 px-5 py-2 rounded-lg max-w-max">
                    ⬅ Back
                </a>
            </div>

        </div>@endsection
