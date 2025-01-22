@include('shared.header')

<div class="admin-tokens-page">
    <table>
        <tr>
            <th>{{__('admin.email')}}</th>
            <th>{{__('admin.token')}}</th>
            <th>{{__('admin.createdAt')}}</th>
            <th>{{__('admin.delete')}}</th>
        @foreach ($tokens as $token)
            <tr>
                <td>{{ $token->email  }}</td>
                <td>{{ $token->token  }}</td>
                <td>{{ $token->created_at  }}</td>
                <td>
                    <form method="POST" action="{{ route('management.admin.tokens.destroy', $token->email) }}">
                        @csrf
                        @method('delete')
                        <button type="submit">X</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <div id="addUserModal" class="admin-modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>{{__('admin.addNewUser')}}</h2>
            <form method="POST" action="{{ route('management.admin.tokens.store') }}" id="addUserForm">
                @csrf
                <div class="form-group">
                    <label for="email">{{__('admin.email')}}</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <button type="submit">{{__('admin.generateToken')}}</button>
            </form>
        </div>
    </div>

    <a href="#" id="openModalBtn">{{__('admin.addNewUser')}}</a>
</div>

<style>
.admin-tokens-page {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
}

.admin-tokens-page table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
    border-radius: 8px;
    overflow: hidden;
}

.admin-tokens-page th,
.admin-tokens-page td {
    padding: 10px 12px;
    text-align: left;
}

.admin-tokens-page th {
    background-color:rgb(255, 123, 0);
    color: white;
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 0.03em;
    border-bottom: 2px solid #ddd;
}

.admin-tokens-page td {
    border-bottom: 1px solid #ddd;
    font-size: 13px;
}

.admin-tokens-page tr:hover {
    background-color: #f9f9f9;
    cursor: pointer;
}

.admin-tokens-page button {
    background-color: #ff9800;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 6px 10px;
    cursor: pointer;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    transition: background-color 0.3s;
}

.admin-tokens-page button:hover {
    background-color: #b46d02;
}

.admin-tokens-page a {
    display: inline-block;
    margin: 10px 0;
    text-decoration: none;
    background-color:#ff9800;
    color: white;
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
    transition: background-color 0.3s;
}

.admin-tokens-page a:hover {
    background-color:  #b46d02;
}

@media (max-width: 768px) {
    .admin-tokens-page table {
        font-size: 11px;
    }

    .admin-tokens-page th,
    .admin-tokens-page td {
        padding: 8px;
    }

    .admin-tokens-page button,
    .admin-tokens-page a {
        font-size: 11px;
    }
}

.admin-modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.admin-modal .modal-content {
    position: relative;
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 500px;
}

.admin-modal .close {
    position: absolute;
    right: 15px;
    top: 10px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    width: 30px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.admin-modal .close:hover {
    color: #333;
    background-color: #f0f0f0;
}

.admin-modal .form-group {
    margin-bottom: 15px;
}

.admin-modal .form-group label {
    display: block;
    margin-bottom: 5px;
}

.admin-modal .form-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

@media (max-width: 768px) {
    .admin-modal .modal-content {
        width: 95%;
        margin: 10% auto;
    }
}
</style>

<script>
const modal = document.getElementById("addUserModal");
const btn = document.getElementById("openModalBtn");
const span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
