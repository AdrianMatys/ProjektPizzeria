@include('shared.header')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #fff3e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            background-color: #fff9e6;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        h1 {
            color: #ff8c00;
            font-weight: bold;
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
            margin-bottom: 15px;
        }
        .btn-group-vertical > .btn {
            margin-bottom: 5px;
        }
        .table {
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .table thead {
            background-color: #ffa726;
            color: white;
        }
        .btn-primary {
            background-color: #ff9800;
            border-color: #ff9800;
        }
        .btn-primary:hover {
            background-color: #b46d02;
            border-color: #b46d02;
        }
        .btn-danger {
            background-color: #ff5722;
            border-color: #ff5722;
        }
        .btn-success {
            background-color: #ffa726;
            border-color: #ffa726;
        }
        .btn-horizontal{
            display: flex;
            align-items: center;
            gap:1rem;
        }
        .btn-trash{
            background-color: none;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4"><i class="fas fa-pizza-slice me-2"></i>Panel pracownika pizzerii</h1>
        
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-clipboard-list me-2"></i>Bieżące zamówienia
            </h2>
            <div class="section-content">
                @foreach($groupedOrders as $status => $orders)
                <table class="table table-striped" id="ordersTable">
                    
                    <thead>
                        <tr>
                            <th>{{__('employee.orderId')}}</th>
                            <th>{{__('employee.client')}}</th>
                            <th>{{__('employee.createdAt')}}</th>
                            <th>{{__('employee.status')}}</th>
                            <th>{{__('employee.details')}}</th>
                        </tr>
                    </thead>
                    @foreach($orders as $order)
                    <tbody>
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="pending">
                                    <button class="btn-primary" type="submit">{{__('employee.pending')}}</button>
                                </form>
                                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="in_progress">
                                    <button class="btn-primary" type="submit">{{__('employee.inProgress')}}</button>
                                </form>
                                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button class="btn-primary" type="submit">{{__('employee.completed')}}</button>
                                </form>
                                <form action="{{ route('management.employee.orders.updateStatus', $order->id )}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button class="btn-primary" type="submit">{{__('employee.cancelled')}}</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
                @endforeach
            </div>
        </div>
        
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-utensils me-2"></i>{{__('employee.menuManagement')}}
            </h2>
            <div class="section-content">
                <table class="table table-striped" id="menuTable">
                    @foreach($pizzas as $pizza)
                    <thead>
                        <tr>
                            <th>{{__('employee.pizzaName')}}</th>
                            <th>{{__('employee.ingredients')}}</th>
                            <th>{{__('employee.pizzaCost')}}</th>
                            <th>{{__('employeeactions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$pizza->name}}</td>
                            <td>{{$pizza->ingredients->map(fn($ingredient) => $ingredient->translatedName)->join(', ')}}</td>
                            <td>{{$pizza->price}}</td>
                            <td>
                                <div class="btn-horizontal">
                                    <a href={{ route("management.employee.pizzas.edit", $pizza) }}>{{__('employee.edit')}}</a>
                                    <form action="{{ route('management.employee.pizzas.destroy', $pizza->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn-primary" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                        </svg></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
                <button class="btn btn-success" onclick="openAddModal()">
                    <i class="fas fa-plus me-1"></i>{{__('employee.addNewPizza')}}
                </button>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>