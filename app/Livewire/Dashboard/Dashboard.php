<?php

namespace App\Livewire\Dashboard;

use App\Models\Employee;
use Livewire\Component;

class Dashboard extends Component
{
    public $adminCount;
    public $employeeCount;

    public function render()
    {
        // Count the total number of Admins and Employees
        // $this->adminCount = Employee::where('role', 1)->count();
        // $this->employeeCount = Employee::where('role', 2)->count();
        return view(
            'livewire.dashboard.dashboard',
            [
                'adminCount' => $this->adminCount,
                'employeeCount' => $this->employeeCount,
            ]
        );
    }
}
