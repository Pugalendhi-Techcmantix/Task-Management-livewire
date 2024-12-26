<?php

namespace App\Livewire\Dashboard;

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pending extends Component
{

    public $myTasks;

    public function render()
    {
        $role = Auth::user()->role_id;
        // Get the authenticated user
        $user = Auth::user();
        // Fetch only tasks assigned to the current user with status "Pending"
        $this->myTasks = Tasks::where('employee_id', $user->id)
            ->where('status', 1) // Fetch only "Pending" tasks
            ->get();
        return view(
            'livewire.dashboard.pending',
            [
                'role' => $role,
                'myTasks' => $this->myTasks,
            ]
        );
    }
}
