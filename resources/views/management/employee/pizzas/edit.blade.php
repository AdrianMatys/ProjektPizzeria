@include('shared.header')

<div>
    <button onclick="addNewIngredient()">{{__('employee.addNewIngredient')}}</button>
</div>
<form action="{{ route('management.employee.pizzas.update', $pizza) }}" method="post">
    @csrf
    @method('put')
    <br>
    <label for="name">{{__('employee.pizzaName')}}:</label><br>
    <input type="text" name="name" id="name" value="{{$pizza->name}}"><br><br>
    <label for="name">{{__('employee.pizzaPrice')}}:</label><br>
    <input type="number" min="0" step="0.01" name="price" id="price" value="{{$pizza->price}}"><br><br>

    <table id="ingredientsTable">
        <tr>
            <th>{{__('employee.ingredients')}}</th>
            <th>{{__('employee.remove')}}</th>
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
        options += '<option value="{{$ingredient->id}}">{{ $ingredient->translatedName }}</option>'
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


