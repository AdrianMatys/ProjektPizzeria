@include('shared.header')

<h1>{{__('admin.dailyIngredientUsage')}}</h1>
<table>
    <tr>
        <th>{{__('admin.name')}}</th>
        <th>{{__('admin.quantity')}}</th>
    </tr>
    @foreach($dailyStatistics['ingredients'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
</table>
<h1>{{__('admin.dailyPizzaOrders')}}</h1>
<table>
    <tr>
        <th>{{__('admin.name')}}</th>
        <th>{{__('admin.quantity')}}</th>
    </tr>
    @foreach($dailyStatistics['pizzas'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
    <tr>
        <td>{{__('admin.editedPizza')}}</td>
        <td>{{$dailyStatistics['products']['EditedPizza'] ?? 0}}</td>
    </tr>
    <tr>
        <td>{{__('admin.customPizza')}}</td>
        <td>{{$dailyStatistics['products']['CustomPizza'] ?? 0}}</td>
    </tr>
</table>

<h1>{{__('admin.weeklyIngredientUsage')}}</h1>
<table>
    <tr>
        <th>{{__('admin.name')}}</th>
        <th>{{__('admin.quantity')}}</th>
    </tr>
    @foreach($weeklyStatistics['ingredients'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
</table>

<h1>{{__('admin.weeklyPizzaOrders')}}</h1>
<table>
    <tr>
        <th>{{__('admin.name')}}</th>
        <th>{{__('admin.quantity')}}</th>
    </tr>
    @foreach($weeklyStatistics['pizzas'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
    <tr>
        <td>{{__('admin.editedPizza')}}</td>
        <td>{{$weeklyStatistics['products']['EditedPizza'] ?? 0}}</td>
    </tr>
    <tr>
        <td>{{__('admin.customPizza')}}</td>
        <td>{{$weeklyStatistics['products']['CustomPizza'] ?? 0}}</td>
    </tr>
</table>

<h1>{{__('admin.monthlyIngredientUsage')}}</h1>
<table>
    <tr>
        <th>{{__('admin.name')}}</th>
        <th>{{__('admin.quantity')}}</th>
    </tr>
    @foreach($monthlyStatistics['ingredients'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
</table>
<h1>{{__('admin.monthlyPizzaOrders')}}</h1>
<table>
    <tr>
        <th>{{__('admin.name')}}</th>
        <th>{{__('admin.quantity')}}</th>
    </tr>
    @foreach($monthlyStatistics['pizzas'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
    <tr>
        <td>{{__('admin.editedPizza')}}</td>
        <td>{{$monthlyStatistics['products']['EditedPizza'] ?? 0}}</td>
    </tr>
    <tr>
        <td>{{__('admin.customPizza')}}</td>
        <td>{{$monthlyStatistics['products']['CustomPizza'] ?? 0}}</td>
    </tr>
</table>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    th {
        background-color: #f4f4f4;
        color: #333;
        font-weight: bold;
        text-transform: uppercase;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    h1 {
        font-family: Arial, sans-serif;
        font-size: 24px;
        color: #333;
        text-align: left;
        border-bottom: 2px solid #ddd;
        margin-bottom: 10px;
        padding-bottom: 5px;
    }

    td {
        font-family: Arial, sans-serif;
        font-size: 14px;
    }
</style>
