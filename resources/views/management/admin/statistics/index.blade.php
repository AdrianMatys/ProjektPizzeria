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
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
