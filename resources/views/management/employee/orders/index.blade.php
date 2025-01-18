@include('shared.header')

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
