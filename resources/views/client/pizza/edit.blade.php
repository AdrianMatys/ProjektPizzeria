@include('shared.header')

<script>
    function addModifiedToCart(itemId, itemType, quantity, price, name){
        window.cart.addItem(itemId, itemType, quantity, price, name);
    }
</script>

<button onclick="addNewIngredient()">{{__('client.addNewIngredient')}}</button>
<form action="{{ route('client.pizza.update', $pizza) }}" method="post">
    @csrf
    @method('put')

    <table id="ingredientsTable">
        <tr>
            <th>{{__('client.ingredients')}}</th>
            <th>{{__('client.remove')}}</th>
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
    <button type="submit" onclick="addModifiedToCart(0, 'editedPizza', 1, 50, 'Edited Pizza')">{{__('client.addToCart')}}</button>
    <a href={{ route("client.menu.index") }}>{{__('client.cancel')}}</a>
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
        let cell2 = newRow.insertCell(1);
        cell1.innerHTML = ''+
            '<select name="ingredient[]]" id="ingredient[]">' +
            options +
            '</select>'
        cell2.innerHTML = '<button onclick="removeIngredient(1)">X</button>'
    }
</script>

<style>
    /* Styl dla tabeli */
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
        background-color: #f9f9f9;
    }
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    /* Styl dla przycisków */
    button {
        background-color: #FF9800;
        color: white;
        border: none;
        padding: 10px 15px;
        margin: 5px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    button:active {
        background-color: #004080;
    }

    /* Styl dla formularza */
    form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Styl dla linku anulowania */
    a {
        display: inline-block;
        color: #FF9800;
        text-decoration: none;
        margin-top: 10px;
        font-size: 14px;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Styl ogólny dla strony */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }

    /* Styl dla nagłówka */
    h1, h2, h3 {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Dostosowanie pola select */
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

</style>
