<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SEO Report</title>
    <style>
        body {
            font-family: sans-serif;
        }
        h1 {
            text-align: center;
        }
        .section {
            margin-bottom: 20px;
        }
        .good { color: green; }
        .warning { color: orange; }
        .bad { color: red; }
    </style>
</head>
<body>

<h1>SEO Analysis Report</h1>

<div class="section">
    <strong>URL:</strong> {{ $analysis->url }}<br>
    <strong>Score:</strong> {{ $analysis->score }}/100
</div>

<div class="section">
    <h3>Website Info</h3>
    <p>Title: {{ $analysis->title }}</p>
    <p>Description: {{ $analysis->description }}</p>
</div>

<div class="section">
    <h3>Structure</h3>
    <p>H1: {{ $analysis->h1 }}</p>
    <p>H2: {{ $analysis->h2 }}</p>
    <p>Images without ALT: {{ $analysis->img_no_alt }}</p>
</div>

<div class="section">
    <h3>Technical</h3>
    <p>HTTPS: {{ $analysis->https ? 'Yes' : 'No' }}</p>
    <p>Sitemap: {{ $analysis->sitemap ? 'Yes' : 'No' }}</p>
    <p>Robots: {{ $analysis->robots ? 'Yes' : 'No' }}</p>
</div>

<div class="section">
    <h3>Keyword</h3>
    <p>Density: {{ number_format($analysis->keyword_density, 2) }}%</p>
</div>

<div class="section">
    <h3>Recommendations</h3>
    <ul>
        @foreach($recommendations as $rec)
            <li class="{{ $rec['status'] }}">
                {{ strtoupper($rec['status']) }} - {{ $rec['text'] }}
            </li>
        @endforeach
    </ul>
</div>

</body>
</html>