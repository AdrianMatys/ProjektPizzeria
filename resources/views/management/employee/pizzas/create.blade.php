@include('shared.header')
<div>
    <button onclick="addNewIngredient()">{{__('employee.addNewIngredient')}}</button>
</div>
<form action="{{ route('management.employee.pizzas.store', $pizza) }}" method="post">
    @csrf
    <br>
    <label for="name">{{__('employee.pizzaName')}}:</label><br>
    <input type="text" name="name" id="name"><br><br>

    <table id="ingredientsTable">
        <tr>
            <th>{{__('employee.ingredients')}}</th>
            <th>{{__('employee.remove')}}</th>
        </tr>
    </table>
    <button type="submit">{{__('employee.savePizza')}}</button>
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


