<?php

namespace App\Http\Controllers;

use App\Actions\Logs\LogDismissalEmployeeAction;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        $users = User::get();

        return view('management.admin.employees.index', compact('users'));
    }

    public function destroy($id, LogDismissalEmployeeAction $logDismissalEmployeeAction)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('management.admin.employees.index')->with('error',
                'Nie udało się usunąć użytkownika');
        }

        $logDismissalEmployeeAction->execute(auth()->id(), ['email' => $user->email]);

        $user->delete();

        return redirect()->route('management.admin.employees.index')->with('success', 'Użytkownik został usunięty');
    }
}
