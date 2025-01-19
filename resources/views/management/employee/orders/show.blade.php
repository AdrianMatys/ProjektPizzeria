@include('shared.header')

<a href="{{ route('management.employee.orders.index') }}">{{__('employee.backToOrders')}}</a>
<br><br>
<table>
    <tr>
        <th>{{__('employee.orderId')}}</th>
        <th>{{__('employee.client')}}</th>
        <th>{{__('employee.status')}}</th>
        <th>{{__('employee.createdAt')}}</th>
        <th>{{__('employee.products')}}</th>
        <th>{{__('employee.changeStatus')}}</th>
    </tr>
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->created_at }}</td>
            <td>
                <table>
                    <tr>
                        <th>{{__('employee.name')}}</th>
                        <th>{{__('employee.ingredients')}}</th>
                        <th>{{__('employee.quantity')}}</th>
                    </tr>
                    @foreach($order->orderItems as $orderItem)
                        <tr>
                            <td>{{$orderItem->item->name}}</td>
                            <td>
                                <table>
                                    @foreach($orderItem->item->ingredients as $ingredient)
                                        <tr>
                                            <td>{{ $ingredient->translatedName }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td>{{$orderItem->quantity}}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
            <td>
                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="pending">
                    <button type="submit">{{__('employee.pending')}}</button>
                </form>
                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="in_progress">
                    <button type="submit">{{__('employee.inProgress')}}</button>
                </form>
                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="completed">
                    <button type="submit">{{__('employee.completed')}}</button>
                </form>
                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit">{{__('employee.cancelled')}}</button>
                </form>
            </td>
        </tr>
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
