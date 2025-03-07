@include('shared.header')

<td><a href={{ route("management.employee.pizzas.create") }}>{{__('employee.addNewPizza')}}</a></td>
<table>
    <tr>
        <th>{{__('employee.pizzaName')}}</th>
        <th>{{__('employee.ingredients')}}</th>
        <th>{{__('employee.pizzaPrice')}}</th>
        <th>{{__('employee.remove')}}</th>
        <th>{{__('employee.edit')}}</th>
    </tr>
    @foreach($pizzas as $pizza)
        <tr>
            <td>{{ $pizza->name }}</td>
            <td>
            @foreach($pizza->ingredients as $ingredient)
                    {{ $ingredient->translatedName }} ({{ $ingredient->quantityOnPizza}} g)
            @endforeach
            </td>
            <td>
                {{$pizza->price}}
            </td>
            <td>
                <form action="{{ route('management.employee.pizzas.destroy', $pizza->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">X</button>
                </form>
            </td>
            <td><a href={{ route("management.employee.pizzas.edit", $pizza) }}>{{__('employee.edit')}}</a></td>
        </tr>
    @endforeach
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>

