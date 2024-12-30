<?php

namespace App\Livewire\Dashboard;

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Progress extends Component
{
    public $myTasks;
    protected $listeners = ['refresh-progress' => '$refresh'];


    public function updateTaskStatus($taskId, $status)
    {
        $task = Tasks::find($taskId);
        if ($task && $task->employee_id === Auth::id()) {
            $task->status = $status;
            $task->save();
            $this->myTasks = $this->myTasks->map(function ($t) use ($taskId, $status) {
                if ($t->id === $taskId) {
                    $t->status = $status;
                }
                return $t;
            });
            $this->dispatch('refresh-progress');
        }
    }
    public function render()
    {

        $role = Auth::user()->role_id;
        // Get the authenticated user
        $user = Auth::user();

        $this->myTasks = Tasks::where('employee_id', $user->id)
            ->where('status', 2)
            ->get();
        return view(
            'livewire.dashboard.progress',
            [
                'role' => $role,
                'myTasks' => $this->myTasks,
            ]
        );
    }
}
