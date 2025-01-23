@include('shared.header')

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('employee.warehouseTitle') }}</title>
    <link rel="icon" href="/assets/pizza_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url('https://abrakadabra.fun/uploads/posts/2022-01/1642956515_32-abrakadabra-fun-p-fon-dlya-pitstsi-37.jpg');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
            min-width: 55rem;
        }
        h1 {
            color: #d32f2f;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            text-wrap: nowrap;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .grid-header {
            background-color: #f8f9fa;
            padding: 15px;
            font-weight: bold;
            text-align: center;
            border-bottom: 2px solid #dee2e6;
        }
        .grid-item {
            padding: 15px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #dee2e6;
        }
        .btn {
            background-color: #ffa500;
            border-color: #ffa500;
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s, box-shadow 0.3s, transform 0.2s;
        }
        .btn:hover {
            background-color: rgb(202, 132, 3);
            border-color: rgb(202, 132, 3);
        }
        .btn:active {
            background-color: rgb(131, 86, 4);
            border-color: rgb(131, 86, 4);
            transform: translateY(2px);
            box-shadow: 0 0 0 4px rgba(255, 165, 0, 0.5);
        }
        .btn:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(255, 165, 0, 0.5);
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-pizza-slice pizza-icon"></i>{{ __('employee.warehouseTitle') }}</h1>



        <div class="mb-3">
            <button class="btn" data-bs-toggle="modal" data-bs-target="#addModal">
                {{ __('employee.addNewIngredient') }}
            </button>
        </div>

        <div id="inventoryList">
            @if($ingredients->count() > 0)
                <div class="grid-container">

                    <div class="grid-header">{{ __('employee.ingredientName') }}</div>
                    <div class="grid-header">{{ __('employee.ingredientQuantity') }}</div>
                    <div class="grid-header">{{ __('employee.unit') }}</div>
                    <div class= "grid-header">{{ __('employee.minQuantity') }}</div>
                    <div class= "grid-header">{{ __('employee.price') }}</div>
                    <div class="grid-header">{{ __('employee.delete') }}</div>
                    <div class="grid-header">{{ __('employee.edit') }}</div>


                    @foreach($ingredients as $ingredient)
                        <div class="grid-item ingredient-name">
                            {{  $ingredient->name }}
                        </div>
                        <div class="grid-item">{{ $ingredient->quantity }}</div>
                        <div class="grid-item">{{ $ingredient->unit }}</div>
                        <div class="grid-item">{{ $ingredient->minQuantity }}</div>
                        <div class="grid-item">{{ $ingredient->price }}</div>
                        <div class="grid-item">
                            <form action="{{ route('management.employee.ingredients.destroy', $ingredient->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" style="background-color: #d32f2f; border-color: #d32f2f;">
                                    X
                                </button>
                            </form>
                        </div>
                        <div class="grid-item">
                            <button class="btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    data-id="{{ $ingredient->id }}"
                                    data-name="{{ $ingredient->name }}"
                                    data-quantity="{{ $ingredient->quantity }}"
                                    data-minQuantity="{{ $ingredient->minQuantity }}"
                                    data-price="{{ $ingredient->price }}"
                                    data-unit="{{ $ingredient->unit }}">
                                {{ __('employee.edit') }}
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    {{ __('employee.noIngredients') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add Modal HTML -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">{{ __('employee.addNewIngredient') }}</h5>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="addForm" action="{{ route('management.employee.ingredients.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="ingredientName" class="form-label">{{ __('employee.ingredientName') }}</label>
                            <input type="text" class="form-control" id="ingredientName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="ingredientQuantity" class="form-label">{{ __('employee.ingredientQuantity') }}</label>
                            <input type="number" class="form-control" id="ingredientQuantity" name="quantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="ingredientUnit" class="form-label">{{ __('employee.unit') }}</label>
                            <select class="form-control" id="ingredientUnit" name="unit" required>
                                <option value="g">g</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ingredientMinQuantity" class="form-label">{{ __('employee.minQuantity') }}</label>
                            <input type="number" class="form-control" id="ingredientMinQuantity" name="minQuantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="ingredientPrice" class="form-label">{{ __('employee.price') }}</label>
                            <input type="number" class="form-control" id="ingredientPrice" name="price" required>
                        </div>
                        <button type="submit" class="btn">{{ __('employee.addNewIngredient') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal HTML -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">{{ __('employee.editIngredient') }}</h5>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="ingredientId" name="id">

                        <div class="mb-3">
                            <label for="ingredientName" class="form-label">{{ __('employee.ingredientName') }}</label>
                            <input type="text" class="form-control" id="ingredientName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="ingredientQuantity" class="form-label">{{ __('employee.ingredientQuantity') }}</label>
                            <input type="number" class="form-control" id="ingredientQuantity" name="quantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="ingredientUnit" class="form-label">{{ __('employee.unit') }}</label>
                            <select class="form-control" id="ingredientUnit" name="unit" required>
                                <option value="g">g</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ingredientMinQuantity" class="form-label">{{ __('employee.minQuantity') }}</label>
                            <input type="number" class="form-control" id="ingredientMinQuantity" name="minQuantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="ingredientPrice" class="form-label">{{ __('employee.price') }}</label>
                            <input type="number" class="form-control" id="ingredientPrice" name="price" required>
                        </div>

                        <button type="submit" class="btn">{{ __('employee.saveChanges') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editModal');

        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const quantity = button.getAttribute('data-quantity');
            const minQuantity = button.getAttribute('data-minQuantity');
            const unit = button.getAttribute('data-unit');
            const price = button.getAttribute('data-price');

            document.getElementById('ingredientId').value = id;
            document.getElementById('ingredientName').value = name;
            document.getElementById('ingredientQuantity').value = quantity;
            document.getElementById('ingredientMinQuantity').value = minQuantity;
            document.getElementById('ingredientUnit').value = unit;
            document.getElementById('ingredientPrice').value = price;
        });
    });
</script>

