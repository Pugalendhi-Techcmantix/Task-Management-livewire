<?php

namespace App\Livewire\Dashboard;

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Progress extends Component
{
    public $myTasks;
    protected $listeners = ['refresh-progress' => '$refresh'];
    public $confirm = false;
    public $selectedTaskId, $selectedStatus;

    public function openModal($taskId, $status)
    {
        $this->selectedTaskId = $taskId;
        $this->selectedStatus = $status;
        $this->confirm = true; // Show the modal
    }


    public function updateTaskStatus()
    {
        $task = Tasks::find($this->selectedTaskId);
        if ($task && $task->employee_id === Auth::id()) {
            $task->status = $this->selectedStatus;
            $task->save();

            // Update local task list
            $this->myTasks = $this->myTasks->map(function ($t) {
                if ($t->id === $this->selectedTaskId) {
                    $t->status = $this->selectedStatus;
                }
                return $t;
            });

            $this->dispatch('refresh-progress');// Notify frontend
        }
        $this->confirm = false; // Close the modal
    }
    
    // public function updateTaskStatus($taskId, $status)
    // {
    //     $task = Tasks::find($taskId);
    //     if ($task && $task->employee_id === Auth::id()) {
    //         $task->status = $status;
    //         $task->save();
    //         $this->myTasks = $this->myTasks->map(function ($t) use ($taskId, $status) {
    //             if ($t->id === $taskId) {
    //                 $t->status = $status;
    //             }
    //             return $t;
    //         });
    //         $this->dispatch('refresh-progress');
    //     }
    // }
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
