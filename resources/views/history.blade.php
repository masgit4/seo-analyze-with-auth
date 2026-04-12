@extends('layouts.app')

@section('head')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('body')
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mt-6 mb-6">
                <h1 class="text-3xl font-bold">📊 History Analysis</h1>
                <a href="{{ secure_route('home') }}" class="max-w-max bg-blue-500 px-4 py-2 rounded-lg">
                    + New Analysis
                </a>
            </div>
            <div class="bg-gray-800 p-5 rounded-x1 mb-6">
                <h2 class="text-x1 font-semibold mb-4">SEO Score Trend</h2>
                <canvas id="seoChart"></canvas>
            </div>
            <form method="GET" class="mb-4">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}"
                    placeholder="Search URL..."
                    class="w-full p-3 rounded-lg bg-gray-800 border border-gray-600"
                >
            </form>
@if(session('success'))
                <div class="bg-green-500 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
@endif
            <div class="overflow-x-auto bg-gray-800 rounded-xl">
                <table class="w-full text-left">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="p-3">URL</th>
                            <th class="p-3">Score</th>
                            <th class="p-3">Keyword</th>
                            <th class="p-3">Date</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
@forelse($analyses as $item)
                        <tr class="border-b border-gray-700">
                            <td class="p-3">{{ $item->url }}</td>
                            <td class="p-3">
                                <span class="
                                    px-3 py-1 rounded-full text-sm
@if($item->score >= 80) bg-green-500
@elseif($item->score >= 50) bg-yellow-500
@else bg-red-500
@endif
                                ">
                                    {{ $item->score }}
                                </span>
                            </td>
                            <td class="p-3">
                                {{ number_format($item->keyword_density, 2) }}%
                            </td>
                            <td class="p-3">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="p-3 flex gap-2">
                                <a
                                    href="{{ secure_route('analysis.id', ['id' => $item->id]) }}" 
                                    class="bg-blue-500 px-3 py-1 rounded"
                                >
                                    View
                                </a>
                                <form method="POST" action="{{ secure_route('history.delete', ['id' => $item->id]) }}">
                                @csrf

                                @method('DELETE')

                                    <button 
                                        onclick="return confirm('Hapus data?')"
                                        class="bg-red-500 px-3 py-1 rounded">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
@empty
                        <tr>
                            <td colspan="5" class="p-4 text-center">
                                No data found
                            </td>
                        </tr>
@endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $analyses->links() }}</div>
        </div>
@endsection

@section('script')
            const labels = [
@foreach($chartData as $item)
                    "{{ $item->created_at->format('d M') }}",
@endforeach
            ];

            const data = [
@foreach($chartData as $item)
                    {{ $item->score }},
@endforeach
            ];

            const ctx = document.getElementById('seoChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'SEO Score',
                        data: data,
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    plugins: {
                        legends: {
                            labels: {
                                color: 'white'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: 'white' }
                        },
                        y: {
                            ticks: { color: 'white' }
                        }
                    }
                }
            });
@endsection
