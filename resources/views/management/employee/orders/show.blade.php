@include('shared.return-message')
<a href="{{ route('management.employee.orders.index') }}">Back to orders</a>
<br><br>
<table>
    <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Status</th>
        <th>created at</th>
        <th>items</th>
        <th>Change status</th>
    </tr>
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->created_at }}</td>
            <td>
                <table>
                    @foreach($order->orderItems as $orderItem)
                        <tr>
                            <td>{{$orderItem->item->name}}</td>
                            <td>
                                <table>
                                    @foreach($orderItem->item->ingredients as $ingredient)
                                        <tr>
                                            <td>{{$ingredient->name}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
            <td>
                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="pending">
                    <button type="submit">Pending</button>
                </form>
                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="in_progress">
                    <button type="submit">In Progress</button>
                </form>
                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="completed">
                    <button type="submit">Completed</button>
                </form>
                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit">Cancelled</button>
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
