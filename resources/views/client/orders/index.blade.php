@include('shared.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<div class="mb-5 mt-5 text-center ">
    <h2 style="background:#ff8c00;padding:1rem;margin:60px;border-radius:5px">
        <i class="fas fa-clipboard-list me-2" ></i>{{__('client.currentOrders')}}
    </h2>
<div>
        <table class="table table-striped mt-4 container" id="ordersTable">
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
                                        
                                        <h4 class="order-title mb-3">{{__('navbar.order')}}</h4>
                                        @foreach($order->orderItems as $orderItem)
                                        <div class="mb-3">
                                            <p class="pizza-header" onclick="toggleSection(this)">
                                                {{$orderItem->item->name}}
                                            </p>
                                            <div class="section-content">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>{{__('admin.details')}}</th>
                                                        </tr>
                                                    </thead>
                                                    @foreach($orderItem->item->ingredients as $ingredient)
                                                    <tr>
                                                        <td>{{ $ingredient->translatedName }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class=" modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('admin.close') }}</button>
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
    body {
            background-image: url('https://i.pinimg.com/736x/26/77/80/267780a69527e511a7dfbcb0192190e1.jpg');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Roboto', sans-serif;
        }
    table,
    tr,
    td,
    th {
        border: 1px solid #ff8c00;
        text-align: center;
    }

    .btn-primary {
        background-color: #ff8c00 !important;
        border-color: #ff8c00 !important;
    }

    .btn-primary:hover {
        background-color: #ffa533 !important;
        border-color: #ffa533 !important;
    }

    .modal-header {
        background-color: #fff3e0;
        border-bottom: 2px solid #ff8c00;
    }

    #ordersTable {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #ordersTable thead {
        background-color: #ff8c00;
        color: white;
    }

    #ordersTable tbody tr:hover {
        background-color: #fff3e0;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #fff8ef;
    }

    .section-header {
        cursor: pointer;
        user-select: none;
        padding: 15px;
        background-color: #ffe0b2;
        border-left: 5px solid #ff8c00;
        border-radius: 5px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .section-header:hover {
        background-color: #ffd180;
    }

    .section-header::after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        float: right;
        transition: transform 0.3s ease;
    }

    .section-header.collapsed::after {
        transform: rotate(-90deg);
    }

    .section-content {
        transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
        max-height: 2000px;
        opacity: 1;
        overflow: hidden;
    }

    .section-content.collapsed {
        max-height: 0;
        opacity: 0;
        margin-bottom: 0;
        padding: 0;
    }

    .table {
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .table thead {
        background-color: #ffa726;
        color: white;
    }

    .table thead th {
        padding: 15px;
        font-weight: 600;
        border-bottom: none;
    }

    .order-title {
        color: #ff8c00;
        font-weight: bold;
        border-bottom: 2px solid #ff8c00;
        padding-bottom: 5px;
        margin-top: 20px;
    }

    .pizza-header {
        cursor: pointer;
        user-select: none;
        padding: 12px 20px;
        background-color: #fff3e0;
        border-left: 3px solid #ff8c00;
        border-radius: 5px;
        margin-bottom: 12px;
        transition: all 0.3s ease;
        font-size: 1rem;
        font-weight: 500;
        position: relative;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .pizza-header::after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 15px;
        transition: transform 0.3s ease;
    }

    .pizza-header.collapsed::after {
        transform: rotate(-90deg);
    }

    .pizza-header:hover {
        background-color: #ffe0b2;
        transform: translateX(5px);
    }

    .table-sm {
        background-color: white;
        border-radius: 5px;
    }

    .table-sm td {
        padding: 10px 15px;
        border-bottom: 1px solid #ffe0b2;
    }

    .table-sm tr:last-child td {
        border-bottom: none;
    }

    .modal-content {
        border-radius: 10px;
        overflow: hidden;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: 1px solid #ffe0b2;
        padding: 15px;
    }
    .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
            min-width: 55rem;
        }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSection(header) {
        const content = header.nextElementSibling;
        if (content) {
            header.classList.toggle('collapsed');
            content.style.display = content.style.display === 'none' ? 'block' : 'none';
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const contents = document.querySelectorAll('.section-content');
        const headers = document.querySelectorAll('.pizza-header');
        contents.forEach(content => {
            content.style.display = 'none';
        });
        headers.forEach(header => {
            header.classList.add('collapsed');
        });
    });

    $(document).ready(function() {
        var myModal = document.querySelectorAll('.modal')
        myModal.forEach(function(modal) {
            new bootstrap.Modal(modal);
        });
    });
</script>