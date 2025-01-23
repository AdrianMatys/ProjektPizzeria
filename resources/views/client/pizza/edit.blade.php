@include('shared.header')
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
    async function addToCart(itemId, itemType, quantity, price, name) {
    try {
        const response = await fetch('cart/add', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                user_id: {{auth()->user() ? auth()->user()->id : 'null'}},
                item_id: itemId,
                item_type: itemType,
                quantity: quantity,
                price: price,
            }),
        });
        if (response.ok) {
            const data = await response.json();
            window.cart.addItem(itemId, itemType, quantity, price, name);
        } else {
            console.log('error 1', response);
        }
    } catch (error) {
        console.error("error 2: ", error);
    }
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
    <input type="button" value="{{__('client.add')}}" onclick="addToCart({{$pizza->id}}, 'Pizza', 1, {{$pizza->price}}, '{{ $pizza->name }}')">
    <a href={{ route("client.menu.index") }}>{{__('client.cancel')}}</a>
</form>
<style>
    table, tr, td, th {
        border: 1px solid black;
        text-align: center;
    }
</style>