<?php

namespace App\Livewire\Dashboard;

use App\Models\Employee;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $adminCount;
    public $employeeCount;
    public $taskCount;
    public $mytaskCount;
    public $myTasks;

    public function render()
    {
        // Get the authenticated user
        $user = Auth::user();
        // Count the total number of Admins and Employees
        $this->adminCount = User::where('role_id', 1)->count();
        $this->employeeCount = User::where('role_id', 2)->count();
        $this->taskCount = Tasks::count();
        // Count the number of tasks assigned to the authenticated user
        $this->mytaskCount = Tasks::where('employee_id', $user->id)->count();

        // Get the tasks assigned to the authenticated user
        $this->myTasks = Tasks::where('employee_id', $user->id)->get(); // Fetch tasks assigned to the current user
        return view(
            'livewire.dashboard.dashboard',
            [
                'adminCount' => $this->adminCount,
                'employeeCount' => $this->employeeCount,
                'taskCount' => $this->taskCount,
                'mytaskCount' => $this->mytaskCount,
                'myTasks' => $this->myTasks,
            ]
        );
    }
}
