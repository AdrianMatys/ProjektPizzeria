@include('shared.header')

<table>
    <tr>
        <th>{{__('employee.ingredientName')}}</th>
        <th>{{__('employee.ingredientQuantity')}}</th>
        <th>{{__('employee.price')}}</th>
        <th>{{__('employee.minQuantity')}}</th>
        <th>{{__('employee.unit')}}</th>
        <th>{{__('employee.update')}}</th>
    </tr>
    <tr>
        <form action="{{ route('management.employee.ingredients.update', $ingredient) }}" method="post">
            @csrf
            @method('put')
            <td>
                <input type="text" name="name" id="name" value="{{ $ingredient->name }}">
            </td>
            <td>
                <input type="number" name="quantity" id="quantity" value="{{ $ingredient->quantity }}">
            </td>
            <td>
                <input type="number" min="0" step="0.01" name="price" id="price" value="{{$ingredient->price}}">
            </td>
            <td>
                <input type="number" min="0" step="1" name="minQuantity" id="minQuantity" value="{{$ingredient->minQuantity}}">
            </td>
            <td>
                <select name="unit" id="unit">
                    <option value="g">g</option>
                </select>
            <td>
                <button type="submit">{{__('employee.updateButton')}}</button>
            </td>
        </form>
    </tr>
</table>

<style>
    table, tr, td, th {
        border: 1px solid black;
        text-align: center;
    }
</style>
