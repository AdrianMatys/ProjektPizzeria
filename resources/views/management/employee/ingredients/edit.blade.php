@include('shared.return-message')
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
        <th>unit</th>
    </tr>
    <tr>
        <form action="{{ route('management.employee.ingredients.update', $ingredient) }}" method="post">
            @csrf
            @method('put')
            <td><input type="text" name="name" id="name" value="{{ $ingredient->name }}"></td>
            <td><input type="number" name="quantity" id="quantity" value="{{ $ingredient->quantity }}"></td>
            <td>
                <select name="unit" id="unit">
                    <option value="g">g</option>
                </select>
            <td>
                <button type="submit">Update</button>
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
