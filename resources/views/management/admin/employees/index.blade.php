@include('shared.header')

<h1>{{__('admin.employees')}}</h1>
<table>
    <tr>
        <th>{{__('admin.userName')}}</th>
        <th>{{__('admin.email')}}</th>
        <th>{{__('admin.role')}}</th>
        <th>{{__('admin.createdAt')}}</th>
        <th>{{__('admin.delete')}}</th>
        <th>{{__('admin.forceLogOut')}}</th>
    </tr>
    @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->email }}</td>
            <td>
                <form action="{{ route('management.admin.employees.changeRole', $employee) }}" method="post">
                    @csrf
                    <select name="role" id="role">
                        <option
                            value="admin" {{$employee->role == 'admin' ? 'selected' : ''}}>{{__('admin.administrator')}}</option>
                        <option
                            value="employee" {{$employee->role == 'employee' ? 'selected' : ''}}>{{__('admin.employee')}}</option>
                        <option
                            value="user" {{$employee->role == 'user' ? 'selected' : ''}}>{{__('admin.user')}}</option>
                    </select>
                    <button type="submit" {{ Auth::user()->id == $employee->id ? 'disabled' : '' }}>{{__('admin.changeRole')}}</button>
                </form>
            </td>
            <td>{{ $employee->created_at }}</td>
            <td>
                <form action="{{ route('management.admin.employees.destroy', $employee->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" {{ Auth::user()->id == $employee->id ? 'disabled' : '' }}>X</button>
                </form>
            </td>
            <td>
                <form action="{{ route('management.admin.employees.forcelogout', $employee) }}" method="post">
                    @csrf
                    @if(Auth::user()->id == $employee->id)
                        <button type="submit" disabled>{{__('admin.logOut')}}</button>
                    @else
                        @if($employee->isLoggedIn())
                            <button type="submit">{{__('admin.logOut')}}</button>
                        @else
                            <button type="submit" disabled>{{__('admin.loggedOut')}}</button>
                        @endif
                    @endif
                </form>
            </td>
        </tr>
    @endforeach
</table>
<h1>{{__('admin.users')}}</h1>
<table>
    <tr>
        <th>{{__('admin.userName')}}</th>
        <th>{{__('admin.email')}}</th>
        <th>{{__('admin.role')}}</th>
        <th>{{__('admin.createdAt')}}</th>
        <th>{{__('admin.delete')}}</th>
        <th>{{__('admin.forceLogOut')}}</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('management.admin.employees.changeRole', $user) }}" method="post">
                    @csrf
                    <select name="role" id="role">
                        <option
                            value="admin" {{$user->role == 'admin' ? 'selected' : ''}}>{{__('admin.administrator')}}</option>
                        <option
                            value="employee" {{$user->role == 'employee' ? 'selected' : ''}}>{{__('admin.employee')}}</option>
                        <option
                            value="user" {{$user->role == 'user' ? 'selected' : ''}}>{{__('admin.user')}}</option>
                    </select>
                    <button type="submit" {{ Auth::user()->id == $user->id ? 'disabled' : '' }}>{{__('admin.changeRole')}}</button>
                </form>
            </td>
            <td>{{ $user->created_at }}</td>
            <td>
                <form action="{{ route('management.admin.employees.destroy', $user->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" {{ Auth::user()->id == $user->id ? 'disabled' : '' }}>X</button>
                </form>
            </td>
            <td>
                <form action="{{ route('management.admin.employees.forcelogout', $user) }}" method="post">
                    @csrf
                    @if(Auth::user()->id == $user->id)
                        <button type="submit" disabled>{{__('admin.logOut')}}</button>
                    @else
                        @if($user->isLoggedIn())
                            <button type="submit">{{__('admin.logOut')}}</button>
                        @else
                            <button type="submit" disabled>{{__('admin.loggedOut')}}</button>
                        @endif
                    @endif
                </form>
            </td>
        </tr>
    @endforeach
</table>

<style>
    table, tr, td, th {
        border: 1px solid black;
        text-align: center;
    }
</style>
