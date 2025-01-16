@include('shared.header')

<td><a href={{ route("management.employee.ingredients.create") }}>Add new</a></td>
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
        <th>unit</th>
        <th>delete</th>
        <th>edit</th>
    </tr>
    @foreach($ingredients as $ingredient)
        <tr>
            <td>{{ $ingredient->translations->first()->name ?? $ingredient->name }}</td>
            <td>{{ $ingredient->quantity }}</td>
            <td>{{ $ingredient->unit }}</td>
            <td>
                <form action="{{ route('management.employee.ingredients.destroy', $ingredient->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">X</button>
                </form>
            </td>
            <td><a href={{ route("management.employee.ingredients.edit", $ingredient) }}>Edit</a></td>
        </tr>
    @endforeach
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
