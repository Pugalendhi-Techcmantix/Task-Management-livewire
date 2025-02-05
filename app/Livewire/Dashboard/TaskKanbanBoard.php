<?php

namespace App\Livewire\Dashboard;

use App\Models\Tasks;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public $users = []; // Store users data
    public $query = ''; // User's search input
    public $usersearch = [];
    public $tasksjoin;
    // Fetch users when component loads
    public function loadUsers()
    {
        sleep(2); // Simulate slow loading
        $this->users = User::all(); // Fetch users from database
        $this->usersearch = User::all(); // Fetch users from database
    }

    public function updatedQuery()
    {
        // Search users only when input field loses focus
        $this->usersearch = User::where('name', 'like', '%' . $this->query . '%')->get();
    }



    public function mount()
    {
        $this->fetchTasks();


        // Fetch tasks with employee names
        $this->tasksjoin = DB::table('tasks')
            ->join('users', 'tasks.employee_id', '=', 'users.id')
            ->select('tasks.project_name', 'tasks.area', 'tasks.task_name', 'users.name as employee_name')
            ->get();
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
