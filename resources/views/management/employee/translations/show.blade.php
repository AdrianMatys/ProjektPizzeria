@include('shared.return-message')
<table>
    <tr>
        <th>Ingredient name</th>
        <th>Translation</th>
        <th>Language</th>
        <th>Edit</th>
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
        </tr>
    @endforeach
</table>
<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
