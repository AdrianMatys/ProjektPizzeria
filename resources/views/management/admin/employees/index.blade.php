@include('shared.header')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container">
    <h1><i class="fas fa-users me-2"></i>{{__('admin.employeesManagement')}}</h1>

    <div class="row mb-5">
        <h2 class="text-danger mb-4">{{__('admin.employees')}}</h2>
        <div class="d-flex flex-wrap gap-4">
            @foreach($employees as $employee)
                <div class="employee-card">
                    <div class="avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="employee-name">{{ $employee->name }}</div>
                    <div class="employee-position">{{ $employee->role }}</div>
                    <div class="employee-info-line"><strong>Email:</strong> {{ $employee->email }}</div>
                    <div class="employee-info-line"><strong>Created:</strong> {{ $employee->created_at }}</div>
                    <div class="employee-actions">
                        <form action="{{ route('management.admin.employees.destroy', $employee->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm" {{ Auth::user()->id == $employee->id ? 'disabled' : '' }}>
                                <i class="fas fa-trash-alt me-1"></i>{{__('admin.delete')}}
                            </button>
                        </form>
                        
                        <form action="{{ route('management.admin.employees.forcelogout', $employee) }}" method="post" class="d-inline">
                            @csrf
                            @if(Auth::user()->id == $employee->id)
                                <button type="submit" class="btn btn-warning btn-sm" disabled>
                                    <i class="fas fa-sign-out-alt me-1"></i>{{__('admin.logOut')}}
                                </button>
                            @else
                                @if($employee->isLoggedIn())
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-sign-out-alt me-1"></i>{{__('admin.logOut')}}
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-sign-out-alt me-1"></i>{{__('admin.loggedOut')}}
                                    </button>
                                @endif
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <h2 class="text-danger mb-4">{{__('admin.users')}}</h2>
        <div class="d-flex flex-wrap gap-4">
            @foreach($users as $user)
                <div class="employee-card">
                    <div class="avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="employee-name">{{ $user->name }}</div>
                    <div class="employee-position">{{ $user->role }}</div>
                    <div class="employee-info-line"><strong>Email:</strong> {{ $user->email }}</div>
                    <div class="employee-info-line"><strong>Created:</strong> {{ $user->created_at }}</div>
                    <div class="employee-actions">
                        <form action="{{ route('management.admin.employees.destroy', $user->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm" {{ Auth::user()->id == $user->id ? 'disabled' : '' }}>
                                <i class="fas fa-trash-alt me-1"></i>{{__('admin.delete')}}
                            </button>
                        </form>
                        
                        <form action="{{ route('management.admin.employees.forcelogout', $user) }}" method="post" class="d-inline">
                            @csrf
                            @if(Auth::user()->id == $user->id)
                                <button type="submit" class="btn btn-warning btn-sm" disabled>
                                    <i class="fas fa-sign-out-alt me-1"></i>{{__('admin.logOut')}}
                                </button>
                            @else
                                @if($user->isLoggedIn())
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-sign-out-alt me-1"></i>{{__('admin.logOut')}}
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-sign-out-alt me-1"></i>{{__('admin.loggedOut')}}
                                    </button>
                                @endif
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Roboto', Arial, sans-serif;
        background-color: #FFF8E7;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }

    h1 {
        color: #D32F2F;
        text-align: center;
        margin-bottom: 1.875rem;
        font-weight: bold;
        text-shadow: 0.125rem 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
    }

    .employee-card {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 0.375rem 0.75rem rgba(0, 0, 0, 0.1);
        padding: 1.5625rem;
        transition: all 0.3s ease;
        width: 23.4375rem;
        margin-bottom: 1.25rem;
    }

    .employee-card:hover {
        transform: translateY(-0.3125rem);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15);
    }

    .avatar {
        width: 6.25rem;
        height: 6.25rem;
        margin: 0 auto 1.25rem;
        background-color: #FFA000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .employee-card:hover .avatar {
        transform: scale(1.1);
    }

    .avatar i {
        font-size: 3.125rem;
        color: #fff;
    }

    .employee-name {
        font-size: 1.3em;
        font-weight: bold;
        text-align: center;
        margin-bottom: 0.625rem;
        color: #D32F2F;
    }

    .employee-position {
        text-align: center;
        color: #6c757d;
        margin-bottom: 1.25rem;
        font-style: italic;
    }

    .employee-info-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.9375rem;
        padding: 0.625rem;
        background-color: #f1f3f5;
        border-radius: 0.5rem;
        transition: all 0.3s ease; 
    }

    .employee-info-line:hover {
        background-color: #e9ecef;
    }

    .employee-actions {
        display: flex;
        justify-content: space-around;
        gap: 0.625rem;
        margin-top: 1.25rem;
    }
</style>