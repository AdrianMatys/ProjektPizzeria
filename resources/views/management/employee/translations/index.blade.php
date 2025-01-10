@include('shared.return-message')
<td><a href={{ route("management.employee.translations.create") }}>Add new</a></td>
<br><br>
<table>
    <tr>
        <th>Ingredient name</th>
        <th>Available languages</th>
        <th>Details</th>
    </tr>
    @foreach($translations as $translation)
        <tr>
            <td>{{ $translation->ingredient->name }}</td>
            <td>
                @foreach($translation->ingredient->translations as $ingredientTranslation)
                    {{ $ingredientTranslation->language_code }}
                @endforeach
            </td>
            <td>
                <a href="{{route('management.employee.translations.show', $translation)}}">Show details</a>
            </td>
        </tr>
    @endforeach
</table>
<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
