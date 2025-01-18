@include('shared.header')

<table>
    <tr>
        <th>{{__('employee.ingredientName')}}</th>
        <th>{{__('employee.ingredientQuantity')}}</th>
        <th>{{__('employee.unit')}}</th>
        <th>{{__('employee.add')}}</th>
    </tr>
    <tr>
        <form action="{{ route('management.employee.ingredients.store', $ingredient) }}" method="post">
            @csrf
            <td><input type="text" name="name" id="name" value=""></td>
            <td><input type="number" name="quantity" id="quantity" value="0"></td>
            <td>
                <select name="unit" id="unit">
                    <option value="g">g</option>
                </select>
            <td>
                <button type="submit">{{__('employee.addButton')}}</button>
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
