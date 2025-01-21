@include('shared.header')

<td><a href={{ route("management.employee.pizzas.create") }}>{{__('employee.addNewPizza')}}</a></td>
<table>
    <tr>
        <th>{{__('employee.pizzaName')}}</th>
        <th>{{__('employee.ingredients')}}</th>
        <th>{{__('employee.remove')}}</th>
        <th>{{__('employee.edit')}}</th>
    </tr>
    @foreach($pizzas as $pizza)
        <tr>
            <td>{{ $pizza->name }}</td>
            <td>
            @foreach($pizza->ingredients as $ingredient)
                    {{ $ingredient->translations->first()->name ?? $ingredient->name }} ({{ $ingredient->quantityOnPizza}} g)
            @endforeach
            </td>
            <td>
                <form action="{{ route('management.employee.pizzas.destroy', $pizza->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">X</button>
                </form>
            </td>
            <td><a href={{ route("management.employee.pizzas.edit", $pizza) }}>{{__('employee.edit')}}</a></td>
        </tr>
    @endforeach
</table>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #fdf7e3;
    color: #333;
}

header {
    background-color: #f8cb8c;
    color: #333;
    padding: 15px;
    text-align: center;
    font-size: 1.8rem;
    font-weight: bold;
    border-bottom: 2px solid #e6b678;
}

a {
    color: #f08c2e;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff9e8;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    border: 1px solid #f4d7a3;
    padding: 12px 15px;
    text-align: center;
    vertical-align: middle;
}

th {
    background-color: #ffa62b;
    color: white;
    text-transform: uppercase;
    font-size: 1rem;
}

td {
    font-size: 0.95rem;
    color: #444;
}

tr:nth-child(even) {
    background-color: #fef6e3;
}

tr:hover {
    background-color: #ffeed2;
    cursor: pointer;
}

button {
    background-color: #ffa62b;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 0.9rem;
    border-radius: 4px;
    margin: 2px;
}

button:hover {
    background-color: #e59429;
}

button:focus {
    outline: none;
}

button.delete {
    background-color: #ff6f61;
}

button.delete:hover {
    background-color: #e65b4d;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff9e8;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    border: 1px solid #f4d7a3;
}

h1 {
    text-align: center;
    color: #f08c2e;
    font-size: 2rem;
    margin-bottom: 20px;
}

.add-button {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px auto;
    padding: 12px 20px;
    background-color: #ffa62b;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 8px;
    font-size: 1.2rem;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, background-color 0.2s ease;
    width: fit-content;
}

.add-button:hover {
    background-color: #e59429;
    transform: scale(1.05);
}

.add-button:focus {
    outline: none;
    box-shadow: 0 0 5px #e59429;
}

.add-button-container {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 10px 20px;
}

@media (max-width: 768px) {
    table {
        width: 100%;
    }

    th, td {
        padding: 10px;
        font-size: 0.85rem;
    }

    .add-button-container {
        justify-content: center;
    }

    .add-button {
        width: 100%;
        text-align: center;
    }
}



</style>

