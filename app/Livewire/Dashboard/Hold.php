<?php

namespace App\Livewire\Dashboard;

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Hold extends Component
{
    public $myTasks;
    public function render()
    {
        $role = Auth::user()->role_id;
        // Get the authenticated user
        $user = Auth::user();
      
        $this->myTasks = Tasks::where('employee_id', $user->id)
            ->where('status', 3) 
            ->get();
        return view(
            'livewire.dashboard.hold',
            [
                'role' => $role,
                'myTasks' => $this->myTasks,
            ]
        );
    }
}
