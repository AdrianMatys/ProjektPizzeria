@include('shared.return-message')

<table>
    <tr>
        <th>name</th>
        <th>created at</th>
        <th>items</th>
    </tr>
        <tr>
            <td>{{ $order->user->name }}</td>
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
        </tr>
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
