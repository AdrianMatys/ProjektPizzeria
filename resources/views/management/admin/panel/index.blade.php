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
        .details-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .details-modal-content {
            background-color: #fff9e6;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            position: relative;
            animation: modalSlideDown 0.3s ease-out;
        }

        @keyframes modalSlideDown {
            from {
                transform: translateY(-100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .details-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .details-close:hover {
            color: #000;
        }

        .details-row {
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 1px solid #ffe0b2;
        }

        .details-label {
            font-weight: bold;
            color: #ff8c00;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4"><i class="fas fa-pizza-slice me-2"></i>{{__('admin.pizzeriaAdministratorPanel')}}</h1>
        
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-clipboard-list me-2"></i>{{__('admin.currentOrders')}}
            </h2>
            <div class="section-content">
               
                <table class="table table-striped" id="ordersTable">
                    <thead>
                        <tr>
                        <th>{{__('admin.userName')}}</th>
                        <th>{{__('admin.category')}}</th>
                        <th>{{__('admin.type')}}</th>
                        <th>{{__('admin.date')}}</th>
                        <th>{{__('admin.details')}}</th>
                        </tr>
                    </thead>
                    @foreach($logs as $log)
                    <tbody>

                <tr>
                    <td>{{ $log->user ? $log->user->email : '---' }}</td>
                    <td>{{ $log->type->category->name }}</td>
                    <td>{{ $log->type->name }}</td>
                    <td>{{ $log->created_at }}</td>
                    <td>
                        <button class="btn btn-primary" onclick="showOrderDetails('{{ $log->user ? $log->user->email : `System`}}', 
                            '{{ $log->type->category->name }}', 
                            '{{ $log->type->name }}', 
                            '{{ $log->created_at }}', 
                            '{{ $log->details ?? '' }}', 
                            '{{ $log->status ?? '' }}', 
                            '{{ $log->total_price ?? '' }}')">
                            {{__('admin.showDetails')}}
                        </button>
                    </td>
                </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>  
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-utensils me-2"></i>{{__('admin.dailyIngredientUsage')}}
            </h2>
            <div class="section-content">
                <table class="table table-striped" id="menuTable">
                    <thead>
                        <tr>
                            <th>{{__('admin.name')}}</th>
                            <th>{{__('admin.quantity')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyStatistics['ingredients'] as $name => $quantity)
                            <tr>
                                <td>{{$name}}</td>
                                <td>{{$quantity}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-utensils me-2"></i>{{__('admin.dailyPizzaOrders')}}
            </h2>
            <div class="section-content">
                <table class="table table-striped">
                    <tr>
                        <th>{{__('admin.name')}}</th>
                        <th>{{__('admin.quantity')}}</th>
                    </tr>
                    @foreach($dailyStatistics['pizzas'] as $name => $quantity)
                        <tr>
                            <td>{{$name}}</td>
                            <td>{{$quantity}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>{{__('admin.editedPizza')}}</td>
                        <td>{{$dailyStatistics['products']['EditedPizza'] ?? 0}}</td>
                    </tr>
                    <tr>
                        <td>{{__('admin.customPizza')}}</td>
                        <td>{{$dailyStatistics['products']['CustomPizza'] ?? 0}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-utensils me-2"></i>{{__('admin.weeklyIngredientUsage')}}
            </h2>
            <div class="section-content">
                <table class="table table-striped">
                    <tr>
                        <th>{{__('admin.name')}}</th>
                        <th>{{__('admin.quantity')}}</th>
                    </tr>
                    @foreach($weeklyStatistics['ingredients'] as $name => $quantity)
                        <tr>
                            <td>{{$name}}</td>
                            <td>{{$quantity}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-utensils me-2"></i>{{__('admin.weeklyPizzaOrders')}}
            </h2>
            <div class="section-content">
                <table class="table table-striped">
                    <tr>
                        <th>{{__('admin.name')}}</th>
                        <th>{{__('admin.quantity')}}</th>
                    </tr>
                    @foreach($weeklyStatistics['pizzas'] as $name => $quantity)
                        <tr>
                            <td>{{$name}}</td>
                            <td>{{$quantity}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>{{__('admin.editedPizza')}}</td>
                        <td>{{$weeklyStatistics['products']['EditedPizza'] ?? 0}}</td>
                    </tr>
                    <tr>
                        <td>{{__('admin.customPizza')}}</td>
                        <td>{{$weeklyStatistics['products']['CustomPizza'] ?? 0}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-utensils me-2"></i>{{__('admin.monthlyIngredientUsage')}}
            </h2>
            <div class="section-content">
                <table class="table table-striped">
                    <tr>
                        <th>{{__('admin.name')}}</th>
                        <th>{{__('admin.quantity')}}</th>
                    </tr>
                    @foreach($monthlyStatistics['ingredients'] as $name => $quantity)
                        <tr>
                            <td>{{$name}}</td>
                            <td>{{$quantity}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-utensils me-2"></i>{{__('admin.monthlyPizzaOrders')}}
            </h2>
            <div class="section-content">
                <table class="table table-striped">
                    <tr>
                        <th>{{__('admin.name')}}</th>
                        <th>{{__('admin.quantity')}}</th>
                    </tr>
                    @foreach($monthlyStatistics['pizzas'] as $name => $quantity)
                        <tr>
                            <td>{{$name}}</td>
                            <td>{{$quantity}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>{{__('admin.editedPizza')}}</td>
                        <td>{{$monthlyStatistics['products']['EditedPizza'] ?? 0}}</td>
                    </tr>
                    <tr>
                        <td>{{__('admin.customPizza')}}</td>
                        <td>{{$monthlyStatistics['products']['CustomPizza'] ?? 0}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div id="orderDetailsModal" class="details-modal">
        <div class="details-modal-content">
            <span class="details-close" onclick="closeDetailsModal()">&times;</span>
            <h2 class="mb-4"><i class="fas fa-info-circle me-2"></i>{{__('admin.orderDetails')}}</h2>
            <div id="orderDetailsContent">
            </div>
        </div>
    </div>

    <script>
        function showOrderDetails(email, category, type, date, details, status, totalPrice) {
            const content = document.getElementById('orderDetailsContent');
            content.innerHTML = `
                <div class="details-row">
                    <span class="details-label">{{__('admin.userName')}}: </span>
                    <span>${email}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">{{__('admin.category')}}: </span>
                    <span>${category}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">{{__('admin.type')}}: </span>
                    <span>${type}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">{{__('admin.date')}}: </span>
                    <span>${date}</span>
                </div>
                ${details ? `
                    <div class="details-row">
                        <span class="details-label">{{__('admin.additionalDetails')}}: </span>
                        <span>${details}</span>
                    </div>
                ` : ''}
                ${status ? `
                    <div class="details-row">
                        <span class="details-label">{{__('admin.status')}}: </span>
                        <span>${status}</span>
                    </div>
                ` : ''}
                ${totalPrice ? `
                    <div class="details-row">
                        <span class="details-label">{{__('admin.totalPrice')}}: </span>
                        <span>${totalPrice}</span>
                    </div>
                ` : ''}
            `;
            
            document.getElementById('orderDetailsModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeDetailsModal() {
            document.getElementById('orderDetailsModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        window.onclick = function(event) {
            const modal = document.getElementById('orderDetailsModal');
            if (event.target == modal) {
                closeDetailsModal();
            }
        }
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDetailsModal();
            }
        });
    </script>
</body>