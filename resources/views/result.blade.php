<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-6">

<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <h1 class="text-3xl font-bold mb-6">📊 Analysis Result</h1>

    <a href="/export/{{ $analysis->id }}" 
        class="bg-purple-500 hover:bg-purple-600 px-4 py-2 rounded-lg mt-4 inline-block">
        📄 Download PDF
    </a>

    <!-- GRID -->
    <div class="grid md:grid-cols-2 gap-6">

        <!-- Website Info -->
        <div class="bg-gray-800 p-5 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-3">🌐 Website Info</h2>
            <p><b>URL:</b> {{ $analysis->url }}</p>
            <p><b>Title:</b> {{ $analysis->title }}</p>
            <p><b>Description:</b> {{ $analysis->description }}</p>
        </div>

        <!-- Technical SEO -->
        <div class="bg-gray-800 p-5 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-3">⚙️ Technical SEO</h2>
            <p>HTTPS: {{ $analysis->https ? '✅ Yes' : '❌ No' }}</p>
            <p>Sitemap: {{ $analysis->sitemap ? '✅ Found' : '❌ Not Found' }}</p>
            <p>Robots.txt: {{ $analysis->robots ? '✅ Found' : '❌ Not Found' }}</p>
            <p>Canonical: {{ $analysis->canonical ? '✅ Yes' : '❌ No' }}</p>
            <p>Open Graph: {{ $analysis->og_tags ? '✅ Yes' : '❌ No' }}</p>
        </div>

        <!-- Structure -->
        <div class="bg-gray-800 p-5 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-3">📑 Page Structure</h2>
            <p>H1: {{ $analysis->h1 }}</p>
            <p>H2: {{ $analysis->h2 }}</p>
            <p>Images without ALT: {{ $analysis->img_no_alt }}</p>
        </div>

        <!-- Links -->
        <div class="bg-gray-800 p-5 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-3">🔗 Link Analysis</h2>
            <p>Internal Links: {{ $analysis->internal_links }}</p>
            <p>External Links: {{ $analysis->external_links }}</p>
        </div>

        <!-- Keyword -->
        <div class="bg-gray-800 p-5 rounded-xl shadow md:col-span-2">
            <h2 class="text-xl font-semibold mb-3">🔍 Keyword Analysis</h2>
            <p>Keyword Density: {{ number_format($analysis->keyword_density, 2) }}%</p>
        </div>

        <!-- SCORE -->
        <div class="bg-gray-800 p-5 rounded-xl shadow md:col-span-2">
            <h2 class="text-xl font-semibold mb-4">🚀 SEO Score</h2>

            <div class="w-full bg-gray-700 rounded-full h-6">
                <div 
                    class="bg-green-500 h-6 rounded-full text-center text-sm font-semibold"
                    style="width: {{ $analysis->score }}%">
                    {{ $analysis->score }}/100
                </div>
            </div>
        </div>

        <div class="bg-gray-800 p-5 rounded-xl mt-6">
            <h2 class="text-xl font-semibold mb-4">🧠 SEO Recommendations</h2>
        
            <ul class="space-y-2">
                @foreach($recommendations as $rec)
                    <li class="
                        p-3 rounded-lg flex items-center gap-2
                        @if($rec['status'] == 'good') bg-green-500
                        @elseif($rec['status'] == 'warning') bg-yellow-500
                        @else bg-red-500
                        @endif
                    ">
                        <span>
                            @if($rec['status'] == 'good') ✅
                            @elseif($rec['status'] == 'warning') ⚠️
                            @else ❌
                            @endif
                        </span>
        
                        <span>{{ $rec['text'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

    <!-- BACK -->
    <div class="mt-6">
        <a href="/" class="bg-blue-500 hover:bg-blue-600 px-5 py-2 rounded-lg">
            ⬅ Back
        </a>
    </div>

</div>

</body>
</html>