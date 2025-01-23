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
            align-items: center;
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
        .btn-horizontal {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-horizontal form {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }
        .btn-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #ffa726;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            height: 38px;
            margin: 0;
        }
        .btn-edit:hover {
            background-color: #ff8c00;
            transform: scale(1.05);
            text-decoration: none;
            color: white;
        }
        .delete-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #ff9800;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            height: 38px;
            margin: 0;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #b46d02;
        }
        .delete-btn svg {
            width: 16px;
            height: 16px;
        }
        #addPizzaModal .modal-content {
  background-color: white;
  margin: 5% auto;
  padding: 20px;
  width: 80%;
  max-width: 600px;
  max-height: 80vh;
  overflow-y: auto;
  position: relative;
  border-radius: 8px;
}

#ingredientsTableContainer {
  max-height: 200px;
  overflow-y: auto;
  margin-bottom: 10px;
}

#editPizzaModal .modal-content {
  background-color: white;
  margin: 5% auto;
  padding: 20px;
  width: 80%;
  max-width: 600px;
  max-height: 80vh;
  overflow-y: auto;
  position: relative;
  border-radius: 8px;
}

#editIngredientsTableContainer {
  max-height: 200px;
  overflow-y: auto;
  margin-bottom: 10px;
}

@media (max-width: 768px) {
  #addPizzaModal .modal-content {
    width: 95%;
    margin: 2% auto;
  }
}

@media (max-width: 768px) {
  #editPizzaModal .modal-content {
    width: 95%;
    margin: 2% auto;
  }
}
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4"><i class="fas fa-pizza-slice me-2"></i>{{__('employee.pizzeriaEmployeePanel')}}</h1>

        <div class="mb-5">
            <h2 class="section-header" onclick="toggleSection(this)">
                <i class="fas fa-clipboard-list me-2"></i>{{__('employee.currentorders')}}
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
                                <div class="btn-horizontal">
                                    <div class="group1">
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
                                </div>
                                <div class="group2">
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
                                </div>
                                </div>
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
                            <th>{{__('employee.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$pizza->name}}</td>
                            <td>{{$pizza->ingredients->map(fn($ingredient) => $ingredient->translatedName)->join(', ')}}</td>
                            <td>{{$pizza->price}}</td>
                            <td>
                                <div class="btn-horizontal">
                                    <a class="btn-edit" onclick="openEditPizzaModal({{$pizza->id}}, '{{$pizza->name}}', {{$pizza->price}}, {{json_encode($pizza->ingredients)}})">{{__('employee.edit')}}</a>
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
                <button class="btn btn-success" onclick="openAddPizzaModal()">
                    <i class="fas fa-plus me-1"></i>{{__('employee.addNewPizza')}}
                </button>
            </div>
        </div>
    </div>


<div id="addPizzaModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; overflow-y: auto;">
    <div class="modal-content">
        <button onclick="closeAddPizzaModal()" style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 20px; cursor: pointer;">×</button>
        <h2>{{__('employee.addNewPizza')}}</h2>
        <form action="{{ route('management.employee.pizzas.store') }}" method="post">
            @csrf
            <label for="name">{{__('employee.pizzaName')}}:</label>
            <input type="text" name="name" id="name" required style="width: 100%; margin-bottom: 10px; padding: 5px;">
            <label for="price">{{__('employee.pizzaPrice')}}:</label>
            <input type="number" min="0" step="0.01" name="price" id="price" required style="width: 100%; margin-bottom: 10px; padding: 5px;">

            <div id="ingredientsTableContainer">
                <table id="ingredientsTable" style="width: 100%;">
                    <tr>
                        <th>{{__('employee.ingredients')}}</th>
                        <th>{{__('employee.remove')}}</th>
                    </tr>
                </table>
            </div>
            <button type="button" onclick="addNewIngredient()" style="background-color: #4CAF50; color: white; padding: 5px; border: none; cursor: pointer; margin-right: 5px;">{{__('employee.addNewIngredient')}}</button>
            <button type="submit" style="background-color: #008CBA; color: white; padding: 5px; border: none; cursor: pointer;">{{__('employee.savePizza')}}</button>
        </form>
    </div>
</div>


<div id="editPizzaModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; overflow-y: auto;">
    <div class="modal-content">
        <button onclick="closeEditPizzaModal()" style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 20px; cursor: pointer;">×</button>
        <h2>{{__('employee.editPizza')}}</h2>
        <form id="editPizzaForm" action="{{ route('management.employee.pizzas.update', '') }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" id="editPizzaId" name="id">
            <label for="editName">{{__('employee.pizzaName')}}:</label>
            <input type="text" name="name" id="editName" required style="width: 100%; margin-bottom: 10px; padding: 5px;">
            <label for="editPrice">{{__('employee.pizzaPrice')}}:</label>
            <input type="number" min="0" step="0.01" name="price" id="editPrice" required style="width: 100%; margin-bottom: 10px; padding: 5px;">

            <div id="editIngredientsTableContainer">
                <table id="editIngredientsTable" style="width: 100%;">
                    <tr>
                        <th>{{__('employee.ingredients')}}</th>
                        <th>{{__('employee.remove')}}</th>
                    </tr>
                </table>
            </div>
            <button type="button" onclick="addNewIngredientToEdit()" style="background-color: #4CAF50; color: white; padding: 5px; border: none; cursor: pointer; margin-right: 5px;">{{__('employee.addNewIngredient')}}</button>
            <button type="submit" style="background-color: #008CBA; color: white; padding: 5px; border: none; cursor: pointer;">{{__('employee.savePizza')}}</button>
        </form>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let options = ''
        @foreach($ingredients as $ingredient)
            options += '<option value="{{$ingredient->id}}">{{ $ingredient->translatedName }}</option>'
        @endforeach

        function removeIngredient(button) {
            let row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        function addNewIngredient() {
            let table = document.getElementById('ingredientsTable')
            let newRow = table.insertRow(-1);
            let cell1 = newRow.insertCell(0);
            let cell2 = newRow.insertCell(1);

            cell1.innerHTML = '' +
                '<select name="ingredient[]" id="ingredient[]" style="width: 100%; padding: 5px;">' +
                    options +
                '</select>'

            cell2.innerHTML = '<button type="button" onclick="removeIngredient(this)" style="background-color: #f44336; color: white; border: none; padding: 5px; cursor: pointer;">X</button>'
        }

        function openAddPizzaModal() {
            document.getElementById('addPizzaModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
            resizeModal();
        }

        function closeAddPizzaModal() {
            document.getElementById('addPizzaModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function resizeModal() {
            const modal = document.querySelector('#addPizzaModal .modal-content');
            const windowHeight = window.innerHeight;
            modal.style.maxHeight = `${windowHeight * 0.8}px`;
        }

        function openEditPizzaModal(id, name, price, ingredients) {
            document.getElementById('editPizzaId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;

            document.getElementById('editPizzaForm').action = "{{ route('management.employee.pizzas.update', '') }}/" + id;

            let table = document.getElementById('editIngredientsTable');
            while (table.rows.length > 1) {
                table.deleteRow(1);
            }

            ingredients.forEach(ingredient => {
                addIngredientToEditTable(ingredient.id);
            });

            document.getElementById('editPizzaModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
            resizeEditModal();
        }

        function closeEditPizzaModal() {
            document.getElementById('editPizzaModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function addNewIngredientToEdit() {
            addIngredientToEditTable();
        }

        function addIngredientToEditTable(selectedId = null) {
            let table = document.getElementById('editIngredientsTable');
            let newRow = table.insertRow(-1);
            let cell1 = newRow.insertCell(0);
            let cell2 = newRow.insertCell(1);

            let select = document.createElement('select');
            select.name = 'ingredient[]';
            select.id = 'ingredient[]';
            select.required = true;
            select.style = 'width: 100%; padding: 5px;';
            select.innerHTML = options;

            if (selectedId) {
                select.value = selectedId;
            }

            cell1.appendChild(select);
            cell2.innerHTML = '<button type="button" onclick="removeIngredient(this)" style="background-color: #f44336; color: white; border: none; padding: 5px; cursor: pointer;">X</button>';
        }

        function resizeEditModal() {
            const modal = document.querySelector('#editPizzaModal .modal-content');
            const windowHeight = window.innerHeight;
            modal.style.maxHeight = `${windowHeight * 0.8}px`;
        }

        window.addEventListener('resize', resizeModal);
        window.addEventListener('resize', resizeEditModal);
    </script>
</body>
</html>
