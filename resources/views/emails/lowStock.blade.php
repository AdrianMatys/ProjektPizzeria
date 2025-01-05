<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Powiadomienie o niskim stanie magazynowym</title>
</head>
<body>
    <h1>Uwaga! Niski stan magazynowy</h1>
    <p>Poniższe składniki kończą się:</p>
    <ul>
        @foreach($ingredients as $ingredient)
            <li>
                <p>{{ $ingredient->translations->first()->name ?? $ingredient->name }}: ({{ $ingredient->quantity }} g)</p>
            </li>
        @endforeach
    </ul>
</body>
</html>
