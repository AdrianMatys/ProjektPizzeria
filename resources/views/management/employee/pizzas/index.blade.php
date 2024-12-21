@include('shared.return-message')
<td><a href={{ route("management.employee.pizzas.create") }}>Add new</a></td>
<table>
    <tr>
        <th>name</th>
        <th>ingredients</th>
        <th>delete</th>
        <th>edit</th>
    </tr>
    @foreach($pizzas as $pizza)
        <tr>
            <td>{{ $pizza->name }}</td>
            <td>
            @foreach($pizza->ingredients as $ingredient)
                    {{ $ingredient->translations->first()->name ?? $ingredient->name }} ({{ $ingredient->pivot->quantity}} g)
            @endforeach
            </td>
            <td>
                <form action="{{ route('management.employee.pizzas.destroy', $pizza->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">X</button>
                </form>
            </td>
            <td><a href={{ route("management.employee.pizzas.edit", $pizza) }}>Edit</a></td>
        </tr>
    @endforeach
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>

