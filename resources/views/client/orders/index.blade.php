@include('shared.header')
@foreach($groupedOrders as $status => $orders)
    {{ $status }} orders
    <table>
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Status</th>
            <th>created at</th>
            <th>Details</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
                <td>
                    <a href="{{route('client.orders.show', $order)}}">Show details</a>
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
