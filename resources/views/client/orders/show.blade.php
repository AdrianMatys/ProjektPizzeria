@include('shared.header')
<a href="{{ route('client.orders.index') }}">{{__('client.backToOrders')}}</a>
<br><br>
<table>
    <tr>
        <th>{{__('client.orderId')}}</th>
        <th>{{__('client.status')}}</th>
        <th>{{__('client.createdAt')}}</th>
        <th>{{__('client.products')}}</th>
        <th>{{__('client.totalPrice')}}</th>
        <th>{{__('client.changeStatus')}}</th>
    </tr>
        <tr>
            <td>{{ $order->id }}</td>
            <td>
                @if($order->status == 'pending')
                    {{ __('client.pending') }}
                @else
                    {{ __('client.inProgress') }}
                @endif
            </td>
            <td>{{ $order->created_at }}</td>
            <td>
                <table>
                    <tr>
                        <th>{{__('client.name')}}</th>
                        <th>{{__('client.ingredients')}}</th>
                        <th>{{__('client.quantity')}}</th>
                        <th>{{__('client.price')}}</th>
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
                            <td>{{$orderItem->price}}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
            <td>
                {{$orderItem->price}} zł
            </td>
            <td>
                <form action="{{ route('client.orders.cancelOrder', $order->id )}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit">{{__('client.cancelOrder')}}</button>
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
