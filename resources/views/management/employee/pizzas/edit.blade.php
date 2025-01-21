@include('shared.header')

<div style="padding: 20px;">
    <div style="background-color: #ffa726; color: black; padding: 10px; display: flex; align-items: center; gap: 8px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 5h18M3 12h18M3 19h18"/>
        </svg>
        <h1 style="font-size: 1.25rem; font-weight: 600;">{{__('employee.menuManagement')}}</h1>
    </div>
    <div style="margin-top: 20px;">
        <button onclick="addNewIngredient()" class="add-button">{{__('employee.addNewIngredient')}}</button>
    </div>
    <form action="{{ route('management.employee.pizzas.update', $pizza) }}" method="post">
        @csrf
        @method('put')
        <br>
        <label for="name">{{__('employee.pizzaName')}}:</label><br>
        <input type="text" name="name" id="name" value="{{$pizza->name}}"><br><br>

        <table id="ingredientsTable">
            <tr>
                <th>{{__('employee.ingredients')}}</th>
                <th>{{__('employee.remove')}}</th>
            </tr>
            @foreach($pizza->ingredients as $ingredient)
                <tr>
                    <td>
                        <select name="ingredient[]]" id="ingredient[]" class="ingredient-select">
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
                        <button type="button" onclick="removeIngredient(this)" class="remove-button">X</button>
                    </td>
                </tr>
            @endforeach
        </table>
        <button type="submit" class="save-button">{{__('employee.savePizza')}}</button>
    </form>
</div>
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #fdf7e3;
        min-height: 100vh;
    }

    table, tr, td {
        border: 1px solid #ddd;
        text-align: center;
        background-color: transparent;
    }

    th {
        background-color: #ffa726;
        color: black;
        padding: 10px;
        border: 1px solid #ddd;
    }

    td {
        padding: 8px;
        background-color: #fff5eb;
    }

    .add-button, .save-button {
        background-color: #ffa726;
        color: black;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        margin: 5px;
    }

    .remove-button {
        background-color: #ff5722;
        color: white;
        border: none;
        padding: 4px 8px;
        border-radius: 4px;
        cursor: pointer;
    }

    select, input[type="text"] {
        padding: 6px;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 100%;
        background-color: #fff5eb;
        color: black;
    }

    .ingredient-select {
        background-color: #fff5eb;
        color: black;
        width: 100%;
    }

    label {
        font-weight: 500;
        color: #333;
    }

    select option {
        background-color: #fff5eb;
        color: black;
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
            '<select name="ingredient[]]" id="ingredient[]" class="ingredient-select">' +
            options +
            '</select>'

        cell2.innerHTML = '<button type="button" onclick="removeIngredient(this)" class="remove-button">X</button>'
    }
</script>

