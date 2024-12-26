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
    public $completed;
    public $incompleted;
    public $totalcompleted;
    public $totalincompleted;

    public function render()
    {
        $role = Auth::user()->role_id;
        // Get the authenticated user
        $user = Auth::user();
        // Count the total number of Admins and Employees
        $this->adminCount = User::where('role_id', 1)->count();
        $this->employeeCount = User::where('role_id', 2)->count();
        $this->taskCount = Tasks::count();
        // Count total completed tasks across the system
        $this->totalcompleted = Tasks::where('status', 4)->count();

        // Count total incomplete tasks across the system
        $this->totalincompleted = Tasks::whereIn('status', [1, 2, 3])->count();
        // Count the number of tasks assigned to the authenticated user
        $this->mytaskCount = Tasks::where('employee_id', $user->id)->count();


        // Get the tasks assigned to the authenticated user
        $this->myTasks = Tasks::where('employee_id', $user->id)->get(); // Fetch tasks assigned to the current user


        $this->completed = Tasks::where('employee_id', $user->id)
            ->where('status', 4)
            ->count();
        // Count incomplete tasks (all statuses except 4)
        $this->incompleted = Tasks::where('employee_id', $user->id)
            ->whereIn('status', [1, 2, 3]) // Statuses: 1 = Pending, 2 = In Progress, 3 = On Hold
            ->count();

        return view(
            'livewire.dashboard.dashboard',
            [
                'role' => $role,
                'adminCount' => $this->adminCount,
                'employeeCount' => $this->employeeCount,
                'taskCount' => $this->taskCount,
                'totalcompleted' => $this->totalcompleted,
                'totalincompleted' => $this->totalincompleted,
                'mytaskCount' => $this->mytaskCount,
                'myTasks' => $this->myTasks,
                'completed' => $this->completed,
                'incompleted' => $this->incompleted,
            ]
        );
    }
}
