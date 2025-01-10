@include('shared.return-message')
<form action="{{ route('management.employee.translations.update', $translation) }}" method="post">
    @csrf
    @method('put')

    <table id="ingredientsTable">
        <tr>
            <th>Ingredient name</th>
            <th>Language code</th>
            <th>Name</th>
        </tr>
        <tr>
            <td>
                {{$translation->ingredient->name}}
            </td>
            <td>
                <input type="text" name="language_code" id="language_code" value="{{$translation->language_code}}">
            </td>
            <td>
                <input type="text" name="name" id="name" value="{{$translation->name}}">
            </td>
        </tr>
    </table>
    <button type="submit">Save translation</button>
</form>
<style>
    table, tr, td, th {
        border: 1px solid black;
        text-align: center;
    }
</style>
