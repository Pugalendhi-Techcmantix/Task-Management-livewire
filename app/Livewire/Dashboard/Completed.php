<?php

namespace App\Livewire\Dashboard;

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Completed extends Component
{
    public $myTasks;
    public function render()
    {

        $role = Auth::user()->role_id;
        // Get the authenticated user
        $user = Auth::user();
    
        $this->myTasks = Tasks::where('employee_id', $user->id)
            ->where('status', 4) 
            ->get();
        return view(
            'livewire.dashboard.completed',
            [
                'role' => $role,
                'myTasks' => $this->myTasks,
            ]
        );
    }
}
