
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semantic Search</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .search-form { margin-bottom: 30px; }
        .search-input { width: 100%; padding: 10px; font-size: 16px; }
        .search-button { margin-top: 10px; padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .search-button:hover { background: #2563eb; }
        .results { margin-top: 20px; }
        .result-item { padding: 10px; border-bottom: 1px solid #eee; }
        .no-results { color: #666; font-style: italic; }
        .distance { color: #666; font-size: 0.8em; }
    </style>
</head>
<body>
    <h1>Semantic Category Search</h1>

    <form class="search-form" action="{{ route('search') }}" method="GET">
        <input
            type="text"
            name="query"
            class="search-input"
            placeholder="Search categories in plain English..."
            value="{{ old('query', $query ?? '') }}"
            required
        >
        <button type="submit" class="search-button">Search</button>
    </form>

    @isset($results)
        <div class="results">
            @if($results->isEmpty())
                <p class="no-results">No results found</p>
            @else
                <h2>Top Results</h2>
                @foreach($results as $result)
                    <div class="result-item">
                        {{ $result->name }}
                        <span class="distance">(distance: {{ number_format($result->distance, 4) }})</span>
                    </div>
                @endforeach
            @endif
        </div>
    @endisset
</body>
</html>
