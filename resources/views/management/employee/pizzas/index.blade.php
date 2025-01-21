@include('shared.header')
<title>Admin</title>
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
        .btn-primary:hover{
            background-color:rgb(171, 103, 0);
            border-color:rgb(171, 103, 0);

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
            display:flex;
            gap:1rem;
            justify-content: center;
        }
        .btn-trash{
            background-color: none;
            padding: 0.2rem;
            border-color:none;
        }
        
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4"><i class="fas fa-pizza-slice me-2"></i>Panel administratora pizzerii</h1>
        
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-clipboard-list me-2"></i>Bieżące zamówienia
            </h2>
            <div class="section-content">
                <table class="table table-striped" id="ordersTable">
                    <thead>
                        <tr>
                            <th>Nr zamówienia</th>
                            <th>Klient</th>
                            <th>Zamówienie</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Jan Kowalski</td>
                            <td>Pepperoni (2), Margherita (1)</td>
                            <td>W przygotowaniu</td>
                            <td>
                                <div class="btn-group-vertical">
                                    <button class="btn btn-primary btn-sm" onclick="updateOrderStatus(this, 1)">
                                        <i class="fas fa-arrow-up me-1"></i>Następny status
                                    </button>
                                    <button class="btn btn-secondary btn-sm" onclick="updateOrderStatus(this, -1)">
                                        <i class="fas fa-arrow-down me-1"></i>Poprzedni status
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Anna Nowak</td>
                            <td>Cztery sery (1), Hawajska (1)</td>
                            <td>W dostawie</td>
                            <td>
                                <div class="btn-group-vertical">
                                    <button class="btn btn-primary btn-sm" onclick="updateOrderStatus(this, 1)">
                                        <i class="fas fa-arrow-up me-1"></i>Następny status
                                    </button>
                                    <button class="btn btn-secondary btn-sm" onclick="updateOrderStatus(this, -1)">
                                        <i class="fas fa-arrow-down me-1"></i>Poprzedni status
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                                    <a class ="btn btn-primary btn-sm" href={{ route("management.employee.pizzas.edit", $pizza) }}>{{__('employee.edit')}}</a>
                                    <form action="{{ route('management.employee.pizzas.destroy', $pizza->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn-trash" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
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
        
        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-chart-bar me-2"></i>Statystyki
            </h2>
            <div class="section-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Łączna liczba zamówień dzisiaj</h5>
                                <p class="card-text display-4" id="totalOrders">15</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Przychód dzisiaj</h5>
                                <p class="card-text display-4"><span id="totalRevenue">450</span> zł</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Najpopularniejsza pizza</h5>
                                <p class="card-text display-4" id="mostPopularPizza">Pepperoni</p>
                            </div>
                        </div>
                    </div>
                </div>
                <h3>Zamówione pizze dzisiaj:</h3>
                <ul id="pizzaOrdersList" class="list-group"></ul>
            </div>
        </div>

        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-user-clock me-2"></i>Logi pracowników
            </h2>
            <div class="section-content">
                <table class="table table-striped" id="employeeLogsTable">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Pracownik</th>
                            <th>Działanie</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edytuj pizzę</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nazwa:</label>
                            <input type="text" class="form-control" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Cena:</label>
                            <input type="number" class="form-control" id="editPrice" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Zapisz zmiany
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Dodaj nową pizzę</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <label for="addName" class="form-label">Nazwa:</label>
                            <input type="text" class="form-control" id="addName" required>
                        </div>
                        <div class="mb-3">
                            <label for="addPrice" class="form-label">Cena:</label>
                            <input type="number" class="form-control" id="addPrice" required>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>Dodaj pizzę
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const orderStatuses = ['Przyjęte', 'W przygotowaniu', 'W dostawie', 'Dostarczono'];

        function toggleSection(header) {
            header.classList.toggle('collapsed');
            header.nextElementSibling.classList.toggle('collapsed');
        }
        function openEditModal(button) {
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            const row = button.closest('tr');
            const name = row.cells[0].textContent;
            const price = parseInt(row.cells[1].textContent);
            
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;
            
            editModal.show();
            
            document.getElementById('editForm').onsubmit = function(e) {
                e.preventDefault();
                const newName = document.getElementById('editName').value;
                const newPrice = document.getElementById('editPrice').value;
                row.cells[0].textContent = newName;
                row.cells[1].textContent = newPrice + ' zł';
                editModal.hide();
                updateStatistics();
                addEmployeeLog(`Edytowano pizzę ${name} na ${newName}, cena: ${newPrice} zł`);
            };
        }

        function openAddModal() {
            const addModal = new bootstrap.Modal(document.getElementById('addModal'));
            addModal.show();
            
            document.getElementById('addForm').onsubmit = function(e) {
                e.preventDefault();
                const name = document.getElementById('addName').value;
                const price = document.getElementById('addPrice').value;
                addPizza(name, price);
                addModal.hide();
                document.getElementById('addForm').reset();
            };
        }