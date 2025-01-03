@include('shared.return-message')
<button onclick="addNewIngredient()">Add new ingredient</button>
<form action="{{ route('client.pizza.update', $pizza) }}" method="post">
    @csrf
    @method('put')

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
                                <option value="{{$availableIngredient->id}}" selected="selected">{{$availableIngredient->name}}</option>
                            @else
                                <option value="{{$availableIngredient->id}}">{{$availableIngredient->name}}</option>
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
    <button type="submit">Add to cart</button>
    <a href={{ route("client.menu.index") }}>Cancel</a>
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
        options += '<option value="{{$ingredient->id}}">{{$ingredient->name}}</option>'
    @endforeach
    function removeIngredient(button) {
        let row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function addNewIngredient() {
        let table = document.getElementById('ingredientsTable')
        let newRow = table.insertRow(-1);
        let cell1 = newRow.insertCell(0);
        let cell2 = newRow.insertCell(1);
        cell1.innerHTML = ''+
            '<select name="ingredient[]]" id="ingredient[]">' +
            options +
            '</select>'
        cell2.innerHTML = '<button onclick="removeIngredient(1)">X</button>'
    }
</script>

