@include('shared.header')
@foreach($groupedOrders as $status => $orders)
    <table>
        <tr>
            <th>{{__('client.orderId')}}</th>
            <th>{{__('client.status')}}</th>
            <th>{{__('client.createdAt')}}</th>
            <th>{{__('client.details')}}</th>
        </tr>
        @foreach($orders as $order)
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
                    <a href="{{route('client.orders.show', $order)}}">{{__('client.showDetails')}}</a>
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
