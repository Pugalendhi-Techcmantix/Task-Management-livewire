<?php

namespace App\Livewire\Dashboard;

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskKanbanBoard extends Component
{

    public $tasks;
    public $statuses = [
        1 => 'Pending',
        2 => 'Progress',
        3 => 'Hold',
        4 => 'Completed'
    ];

    public function mount()
    {
        $this->fetchTasks();
    }

    public function fetchTasks()
    {

        $this->tasks = Tasks::where('employee_id', Auth::id())->get();
    }

    // This method is triggered when the task is dropped into a new status column
    public function updateTaskStatus($taskId, $newStatusId)
    {
        // Find the task and update its status
        $task = Tasks::find($taskId);
        if ($task && $task->employee_id == Auth::id()) {
            $task->status = $newStatusId;
            $task->save();
        }

        // Re-fetch tasks to reflect the updated status
        $this->fetchTasks();
    }


    public function render()
    {
        return view('livewire.dashboard.task-kanban-board');
    }
}
