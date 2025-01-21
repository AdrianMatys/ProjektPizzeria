@include('shared.header')

<td><a href={{ route("management.employee.pizzas.create") }}>{{__('employee.addNewPizza')}}</a></td>
<table>
    <tr>
        <th>{{__('employee.pizzaName')}}</th>
        <th>{{__('employee.ingredients')}}</th>
        <th>{{__('employee.pizzaPrice')}}</th>
        <th>{{__('employee.remove')}}</th>
        <th>{{__('employee.edit')}}</th>
    </tr>
    @foreach($pizzas as $pizza)
        <tr>
            <td>{{ $pizza->name }}</td>
            <td>
                @foreach($pizza->ingredients as $ingredient)
                    {{ $ingredient->translatedName }} ({{ $ingredient->quantityOnPizza}} g)
                @endforeach
            </td>
            <td>
                {{$pizza->price}}
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



@foreach($groupedOrders as $status => $orders)
    <table>
        <tr>
            <th>{{__('employee.orderId')}}</th>
            <th>{{__('employee.client')}}</th>
            <th>{{__('employee.status')}}</th>
            <th>{{__('employee.createdAt')}}</th>
            <th>{{__('employee.details')}}</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
                <td>
                    <a href="{{route('management.employee.orders.show', $order)}}">{{__('employee.showDetails')}}</a>
                </td>
            </tr>
        @endforeach
    </table>
@endforeach


<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
