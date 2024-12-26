<?php

namespace App\View\Components;

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $pending, $progress, $hold, $completed;
    public function render(): View
    {
        $role = Auth::user()->role_id;
        $user = Auth::user();

        // Fetch only tasks assigned to the current user with status "Pending"
        $this->pending = Tasks::where('employee_id', $user->id)
            ->where('status', 1) // Fetch only "Pending" tasks
            ->count(); // Only count the tasks
        $this->progress = Tasks::where('employee_id', $user->id)
            ->where('status', 2)
            ->count();
        $this->hold = Tasks::where('employee_id', $user->id)
            ->where('status', 3)
            ->count();
        $this->completed = Tasks::where('employee_id', $user->id)
            ->where('status', 4)
            ->count();

        return view('layouts.app', [
            'role' => $role,
            'pending' => $this->pending,
            'progress' => $this->progress,
            'hold' => $this->hold,
            'completed' => $this->completed
        ]);
    }
}
