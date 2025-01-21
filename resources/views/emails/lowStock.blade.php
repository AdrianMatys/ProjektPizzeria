<h1>Uwaga! Niski stan magazynowy</h1>
<p>Poniższe składniki kończą się:</p>
<ul>
    @foreach($ingredients as $ingredient)
        <li>
            <p>{{ $ingredient->translatedName }}: ({{ $ingredient->quantity }} g)</p>
        </li>
    @endforeach
</ul>
