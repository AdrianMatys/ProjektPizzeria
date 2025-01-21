@include('shared.header')

<style>
    .orders-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 15px;
    }

    .orders-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        color: #FF8C00;
        font-size: 24px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #FF8C00;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        margin-bottom: 20px;
    }

    .orders-table th {
        background: #FF8C00;
        color: white;
        padding: 12px;
        text-align: left;
        font-weight: 500;
    }

    .orders-table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        color: #333;
    }

    .orders-table tr:nth-child(even) {
        background-color: #fff9f2;
    }

    .orders-table tr:hover {
        background-color: #fff3e6;
    }

    .details-link {
        color: #FF8C00;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    .details-link:hover {
        background-color: #fff3e6;
        text-decoration: underline;
    }

    .status-cell {
        font-weight: 500;
        color: #666;
    }

    .status-buttons {
        display: flex;
        gap: 5px;
    }

    .status-button {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .status-button.next {
        background-color: #4CAF50;
        color: white;
    }

    .status-button.prev {
        background-color: #f44336;
        color: white;
    }

    .status-button:hover {
        opacity: 0.8;
    }
</style>

<div class="orders-container">
    <div class="orders-section">
        <h1 class="section-title">{{__('employee.ordermanagementpanel')}}</h1>
        <table class="orders-table">
            <tr>
                <th>{{__('employee.orderId')}}</th>
                <th>{{__('employee.client')}}</th>
                <th>{{__('employee.status')}}</th>
                <th>{{__('employee.createdAt')}}</th>
                <th>{{__('employee.details')}}</th>
                <th>{{__('employee.actions')}}</th>
            </tr>
            @foreach($groupedOrders as $status => $orders)
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td class="status-cell">{{ $order->status }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <a href="{{route('management.employee.orders.show', $order)}}" class="details-link">
                                {{__('employee.showDetails')}}
                            </a>
                        </td>
                        <td>
                            <div class="status-buttons">
                                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ getPreviousStatus($order->status) }}">
                                    <button type="submit" class="status-button prev">{{__('employee.previousStatus')}}</button>
                                </form>
                                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ getNextStatus($order->status) }}">
                                    <button type="submit" class="status-button next">{{__('employee.nextStatus')}}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endforeach 
        </table>
    </div>
</div>

@php
function getPreviousStatus($currentStatus) {
    $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
    $currentIndex = array_search($currentStatus, $statuses);
    return $currentIndex > 0 ? $statuses[$currentIndex - 1] : $currentStatus;
}
function getNextStatus($currentStatus) {
    $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
    $currentIndex = array_search($currentStatus, $statuses);
    return $currentIndex < count($statuses) - 1 ? $statuses[$currentIndex + 1] : $currentStatus;
}
@endphp