@include('shared.return-message')
<h1>DZIENNE ZUŻYCIE SKŁADNIKÓW</h1>
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
    </tr>
    @foreach($statistics['daily']['ingredients'] as $name => $quantity)
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
    @foreach($statistics['daily']['products']['pizza'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
    <tr>
        <td>EditedPizza</td>
        <td>{{$statistics['daily']['products']['EditedPizza']}}</td>
    </tr>
    <tr>
        <td>CustomPizza</td>
        <td>{{$statistics['daily']['products']['CustomPizza']}}</td>
    </tr>
</table>


<h1>TYGODNIOWE ZUŻYCIE SKŁADNIKÓW</h1>
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
    </tr>
    @foreach($statistics['weekly']['ingredients'] as $name => $quantity)
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
    @foreach($statistics['weekly']['products']['pizza'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
    <tr>
        <td>EditedPizza</td>
        <td>{{$statistics['weekly']['products']['EditedPizza']}}</td>
    </tr>
    <tr>
        <td>CustomPizza</td>
        <td>{{$statistics['weekly']['products']['CustomPizza']}}</td>
    </tr>
</table>


<h1>MIESIĘCZNE ZUŻYCIE SKŁADNIKÓW</h1>
<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
    </tr>
    @foreach($statistics['monthly']['ingredients'] as $name => $quantity)
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
    @foreach($statistics['monthly']['products']['pizza'] as $name => $quantity)
        <tr>
            <td>{{$name}}</td>
            <td>{{$quantity}}</td>
        </tr>
    @endforeach
    <tr>
        <td>EditedPizza</td>
        <td>{{$statistics['monthly']['products']['EditedPizza']}}</td>
    </tr>
    <tr>
        <td>CustomPizza</td>
        <td>{{$statistics['monthly']['products']['CustomPizza']}}</td>
    </tr>
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
