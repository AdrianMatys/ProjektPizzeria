@include('shared.return-message')
<h1>DZIENNE ZUŻYCIE SKŁADNIKÓW</h1>
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
    </tr>
    @foreach($dailyStatistics['ingredients'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
</table>
<h1>DZIENNE ZAMÓWIENIA PIZZY</h1>
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
    </tr>
    @foreach($dailyStatistics['pizzas'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
    <tr>
        <td>EditedPizza</td>
        <td>{{$dailyStatistics['products']['EditedPizza'] ?? 0}}</td>
    </tr>
    <tr>
        <td>CustomPizza</td>
        <td>{{$dailyStatistics['products']['CustomPizza'] ?? 0}}</td>
    </tr>
</table>


<h1>TYGODNIOWE ZUŻYCIE SKŁADNIKÓW</h1>
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
    </tr>
    @foreach($weeklyStatistics['ingredients'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
</table>

<h1>TYGODNIOWE ZAMÓWIENIA PIZZY</h1>
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
    </tr>
    @foreach($weeklyStatistics['pizzas'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
    <tr>
        <td>EditedPizza</td>
        <td>{{$weeklyStatistics['products']['EditedPizza'] ?? 0}}</td>
    </tr>
    <tr>
        <td>CustomPizza</td>
        <td>{{$weeklyStatistics['products']['CustomPizza'] ?? 0}}</td>
    </tr>
</table>


<h1>MIESIĘCZNE ZUŻYCIE SKŁADNIKÓW</h1>
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
    </tr>
    @foreach($monthlyStatistics['ingredients'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
</table>
<h1>MIESIĘCZNE ZAMÓWIENIA PIZZY</h1>
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
    </tr>
    @foreach($monthlyStatistics['pizzas'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
    <tr>
        <td>EditedPizza</td>
        <td>{{$monthlyStatistics['products']['EditedPizza'] ?? 0}}</td>
    </tr>
    <tr>
        <td>CustomPizza</td>
        <td>{{$monthlyStatistics['products']['CustomPizza'] ?? 0}}</td>
    </tr>
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
