@include('shared.header')

<a href="{{ route('management.employee.translations.index') }}">Back to translations</a>
<br><br>
<table>
    <tr>
        <th>Ingredient name</th>
        <th>Translation</th>
        <th>Language</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    @foreach($translations as $translation)
        <tr>
            <td>
                {{ $translation->ingredient->name }}
            </td>
            <td>
                {{ $translation->name }}
            </td>
            <td>
                {{ $translation->language_code }}
            </td>
            <td>
                <a href="{{route('management.employee.translations.edit', $translation)}}">Edit translation</a>
            </td>
            <td>
                <form action="{{ route('management.employee.translations.destroy', $translation->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">X</button>
                </form>
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
