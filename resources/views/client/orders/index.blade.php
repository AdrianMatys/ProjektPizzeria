@include('shared.header')
<div class="mb-5">
    <h2 class="section-header" onclick="toggleSection(this)">
        <i class="fas fa-clipboard-list me-2"></i>{{__('client.currentOrders')}}
    </h2>
    <div class="section-content">
        <table class="table table-striped" id="ordersTable">
            <thead>
                <tr>
                    <th>{{__('client.orderId')}}</th>
                    <th>{{__('client.status')}}</th>
                    <th>{{__('client.createdAt')}}</th>
                    <th>{{__('client.details')}}</th>
                </tr>
            </thead>
            @foreach($orders as $order)
                <tbody>
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>@if($order->status == 'pending')
                                {{__('client.pending') }}
                            @else
                                {{__('client.inProgress') }}
                            @endif
                        </td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                            {{__('client.showOrder') }}
                            </button>
                            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">{{__('client.orderDetails') }} #{{ $order->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>{{__('client.orderId') }}:</strong> {{ $order->id }}</p>
                                            <p><strong>{{__('client.status')}}:</strong>
                                                @if($order->status == 'pending')
                                                    {{__('client.pending')}}
                                                @else
                                                    {{__('client.inProgress') }}
                                                @endif
                                            </p>
                                            <p><strong>{{__('admin.createdAt') }}:</strong> {{ $order->created_at }}</p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('client.close') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            @endforeach
        </table>
    </div>
</div>
<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        var myModal = document.querySelectorAll('.modal')
        myModal.forEach(function(modal) {
            new bootstrap.Modal(modal);
        });
    });
</script>
