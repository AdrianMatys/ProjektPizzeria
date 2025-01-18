<?php

namespace App\Http\Controllers;

use App\Actions\Logs\LogDismissalEmployeeAction;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        $users = User::query()->where('role', 'user')->get();
        $employees = User::query()->whereNot('role', 'user')->get();

        return view('management.admin.employees.index', compact('users', 'employees'));
    }

    public function destroy($id, LogDismissalEmployeeAction $logDismissalEmployeeAction)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('management.admin.employees.index')
                ->with('error', __('admin.failedDeleteUser'));
        }

        $logDismissalEmployeeAction->execute(auth()->id(), ['email' => $user->email]);

        $user->delete();
        return redirect()->route('management.admin.employees.index')->with('success', __('admin.userDeleted'));
    }
    public function forceLogout(User $user){
        $user->forceLogout();
        return redirect()->back()->with('success', __('admin.userLoggedOut'));
    }
}
