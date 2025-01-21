@include('shared.header')

<td><a href={{ route("management.employee.ingredients.create") }}>{{__('employee.addNewIngredient')}}</a></td>
<table>
    <tr>
        <th>{{__('employee.ingredientName')}}</th>
        <th>{{__('employee.ingredientQuantity')}}</th>
        <th>{{__('employee.unit')}}</th>
        <th>{{__('employee.price')}}</th>
        <th>{{__('employee.minQuantity')}}</th>
        <th>{{__('employee.delete')}}</th>
        <th>{{__('employee.edit')}}</th>
    </tr>
    @foreach($ingredients as $ingredient)
        <tr>
            <td>{{ $ingredient->translatedName }}</td>
            <td>{{ $ingredient->quantity }}</td>
            <td>{{ $ingredient->unit }}</td>
            <td>{{ $ingredient->price }}</td>
            <td>{{ $ingredient->minQuantity }}</td>
            <td>
                <form action="{{ route('management.employee.ingredients.destroy', $ingredient->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">X</button>
                </form>
            </td>
            <td><a href={{ route("management.employee.ingredients.edit", $ingredient) }}>{{__('employee.edit')}}</a></td>
        </tr>
    @endforeach
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
