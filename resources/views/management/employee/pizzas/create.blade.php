@include('shared.header')

<button onclick="addNewIngredient()">Add new ingredient</button>
<form action="{{ route('management.employee.pizzas.store', $pizza) }}" method="post">
    @csrf
    <br>
    <label for="name">Name:</label><br>
    <input type="text" name="name" id="name"><br><br>

    <table id="ingredientsTable">
        <tr>
            <th>ingredients</th>
            <th>remove</th>
        </tr>
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
        let cell2 = newRow.insertCell(1);

        cell1.innerHTML = ''+
            '<select name="ingredient[]]" id="ingredient[]">' +
                options +
            '</select>'

        cell2.innerHTML = '<button type="button" onclick="removeIngredient(this)">X</button>'
    }
</script>


