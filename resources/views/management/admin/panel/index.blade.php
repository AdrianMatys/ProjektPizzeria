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
                <tr>
                    <td>{{ $log->user ? $log->user->email : '---' }}</td>
                    <td>{{ $log->type->category->name }}</td>
                    <td>{{ $log->type->name }}</td>
                    <td>{{ $log->created_at }}</td>
                    <td>
                        <a href="{{route('management.admin.logs.show', $log)}}">{{__('admin.showDetails')}}</a>
                    </td>
                </tr>
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
                <tr>
                    <th>{{__('admin.userName')}}</th>
                    <th>{{__('admin.category')}}</th>
                    <th>{{__('admin.type')}}</th>
                    <th>{{__('admin.date')}}</th>
                    <th>{{__('admin.details')}}</th>
                </tr>
                </tr>
                </thead>
                @foreach($logs as $log)
                <tr>
                    <td>{{ $log->user ? $log->user->email : '---' }}</td>
                    <td>{{ $log->type->category->name }}</td>
                    <td>{{ $log->type->name }}</td>
                    <td>{{ $log->created_at }}</td>
                    <td>
                        <a href="{{route('management.admin.logs.show', $log)}}">{{__('admin.showDetails')}}</a>
                    </td>
                </tr>
                @endforeach
            </table>
            <button class="btn btn-success" onclick="openAddModal()">
                <i class="fas fa-plus me-1"></i>{{__('employee.addNewPizza')}}
            </button>
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