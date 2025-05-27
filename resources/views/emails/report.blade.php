<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Citizen Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { margin-top: 20px; color: #333; }
        ul { margin-left: 20px; }
    </style>
</head>
<body>
    <h1>Citizen Report by City</h1>

    @if($cities)
        @foreach($cities as $city)
            <h2>{{ $city->name }}</h2>
            <ul>
                @forelse($city->citizens as $citizen)
                <li>{{ $citizen->first_name }} {{ $citizen->last_name }}</li>
                @empty
                    <li>No citizens registered.</li>
                @endforelse
            </ul>
        @endforeach
    @else
        <p>No cities found.</p>
    @endif

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
