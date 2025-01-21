@include('shared.header')
<div style="margin: 20px;">
    <button onclick="addNewIngredient()" style="background-color: #ffa500; border: none; padding: 10px 15px; color: white; font-size: 16px; border-radius: 5px; cursor: pointer;">
        {{__('employee.addNewIngredient')}}
    </button>
</div>
<form action="{{ route('management.employee.pizzas.store', $pizza) }}" method="post" style="padding: 20px; font-family: Arial, sans-serif; background-color: #fdf7e3; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    @csrf
    <br>
    <label for="name" style="font-size: 16px; font-weight: bold; background-color: #f9f1dc; padding: 5px; border-radius: 5px; display: inline-block;">
        {{__('employee.pizzaName')}}:
    </label><br>
    <input type="text" name="name" id="name" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; background-color: #fdf7e3; font-size: 16px; color: #000; font-family: Arial, sans-serif; text-rendering: optimizeLegibility;"><br><br>

    <table id="ingredientsTable" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f9f1dc; color: #000; font-weight: bold;">
                <th style="padding: 10px; border: 1px solid #ddd;">{{__('employee.ingredients')}}</th>
                <th style="padding: 10px; border: 1px solid #ddd;">{{__('employee.remove')}}</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <button type="submit" style="margin-top: 20px; background-color: #ffa500; border: none; padding: 10px 15px; color: white; font-size: 16px; border-radius: 5px; cursor: pointer;">
        {{__('employee.savePizza')}}
    </button>
</form>

<style>
    body {
        background-color: #fdf7e3; /* Кремовый цвет заднего фона страницы */
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    input[type="text"] {
        background-color: #fdf7e3; /* Кремовый цвет для строки под Pizza Name */
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
        font-size: 16px; /* Чёткий размер текста */
        color: #000; /* Чёрный цвет текста */
        font-family: Arial, sans-serif; /* Ясный и стандартный шрифт */
        text-rendering: optimizeLegibility; /* Оптимизация рендеринга текста */
    }

    table, th, td {
        border: 1px solid #ddd;
        text-align: center;
    }

    th, td {
        padding: 10px;
    }

    th {
        background-color: #f9f1dc; /* Кремовый фон для заголовков таблицы */
    }

    button {
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #ff8c00;
    }

    label {
        background-color: #f9f1dc; /* Кремовый фон для текста */
        padding: 5px;
        border-radius: 5px;
    }
</style>

<script>
    let options = '';
    @foreach($ingredients as $ingredient)
        options += '<option value="{{$ingredient->id}}">{{ $ingredient->translations->first()->name ?? $ingredient->name }}</option>';
    @endforeach

    function removeIngredient(button) {
        let row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function addNewIngredient() {
        let table = document.getElementById('ingredientsTable').getElementsByTagName('tbody')[0];
        let newRow = table.insertRow(-1);
        let cell1 = newRow.insertCell(0);
        let cell2 = newRow.insertCell(1);

        cell1.innerHTML = '<select name="ingredient[]" id="ingredient[]" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">' +
            options +
            '</select>';

        cell2.innerHTML = '<button type="button" onclick="removeIngredient(this)" style="background-color: #ff4d4d; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">X</button>';
    }
</script>
