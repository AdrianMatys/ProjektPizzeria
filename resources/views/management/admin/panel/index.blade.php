@include('shared.header')

<table>
    <tr>
        <th>{{__('admin.userName')}}</th>
        <th>{{__('admin.category')}}</th>
        <th>{{__('admin.type')}}</th>
        <th>{{__('admin.date')}}</th>
        <th>{{__('admin.details')}}</th>
    </tr>
    @foreach($logs as $log)
        <tr>
            <td>{{ $log->user ? $log->user->email : '---' }}</td>
            <td>{{ $log->type->category->name }}</td>
            <td>{{ $log->type->name }}</td>
            <td>{{ $log->created_at }}</td>
            <td>
                <a href="{{route('management.admin.logs.show', $log)}}">{{__('admin.showDetails')}}</a>
            </td>
        </tr>
    @endforeach
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>

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
