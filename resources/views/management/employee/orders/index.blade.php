@include('shared.return-message')

<table>
    <tr>
        <th>name</th>
        <th>created at</th>
        <th>Details</th>
    </tr>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->user->name }}</td>
            <td>{{ $order->created_at }}</td>
            <td>
                <a href="{{route('management.employee.orders.show', $order)}}">Show details</a>
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
