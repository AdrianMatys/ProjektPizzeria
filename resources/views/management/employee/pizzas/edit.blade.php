@include('shared.return-message')
<button onclick="addNewIngredient()">Add new ingredient</button>
<form action="{{ route('management.employee.pizzas.update', $pizza) }}" method="post">
    @csrf
    @method('put')
    <br>
    <label for="name">Name:</label><br>
    <input type="text" name="name" id="name" value="{{$pizza->name}}"><br><br>

    <table id="ingredientsTable">
        <tr>
            <th>ingredients</th>
            <th>remove</th>
        </tr>
        @foreach($pizza->ingredients as $ingredient)
            <tr>
                    <td>
                        <select name="ingredient[]]" id="ingredient[]">

                            @foreach($ingredients as $availableIngredient )
                                @if($availableIngredient->name == $ingredient->name)
                                    <option value="{{$availableIngredient->id}}" selected="selected">{{ $availableIngredient->translations->first()->name ?? $availableIngredient->name }}</option>
                                @else
                                    <option value="{{$availableIngredient->id}}">{{ $availableIngredient->translations->first()->name ?? $availableIngredient->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                <td>
                    <button type="button" onclick="removeIngredient(this)">X</button>
                </td>
            </tr>
        @endforeach
    </table>
    <button type="submit">Save pizza</button>
</form>
<style>
    table, tr, td, th {
        border: 1px solid black;
        text-align: center;
    }
</style>

<script>
    let options = ''
    @foreach($ingredients as $ingredient)
        options += '<option value="{{$ingredient->id}}">{{ $ingredient->translations->first()->name ?? $ingredient->name }}</option>'
    @endforeach
    function removeIngredient(button) {
        let row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function addNewIngredient() {
        let table = document.getElementById('ingredientsTable')
        let newRow = table.insertRow(-1);
        let cell1 = newRow.insertCell(0);
        let cell2 = newRow.insertCell(2);
        cell1.innerHTML = ''+
            '<select name="ingredient[]]" id="ingredient[]">' +
            options +
            '</select>'



        cell2.innerHTML = '<button onclick="removeIngredient(1)">X</button>'
    }
</script>


