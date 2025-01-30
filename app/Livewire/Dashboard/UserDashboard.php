<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;
use App\Models\Tasks;
use Carbon\Carbon;

class UserDashboard extends Component
{

    use Toast;
    public $mytaskCount;
    public $completed;
    public $incompleted;
    public $users;
    public $username;
    public $events = [];
    public $currentTime;
    protected $listeners = ['updateTime'];

    public function mount()
    {
        $this->username = Auth::user()->name;
        $this->updateTime();
        $this->cardsCount();
        $this->events = $this->calendarEvents();
    }

    // Function to update the time
    public function updateTime()
    {
        $this->currentTime = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i:s A');
    }
    public function cardsCount()
    {
        // Get the authenticated user
        $user = Auth::user();
        // Count the number of tasks assigned to the authenticated user
        $this->mytaskCount = Tasks::where('employee_id', $user->id)->count();

        $this->completed = Tasks::where('employee_id', $user->id)
            ->where('status', 4)
            ->count();
        // Count incomplete tasks (all statuses except 4)
        $this->incompleted = Tasks::where('employee_id', $user->id)
            ->whereIn('status', [1, 2, 3]) // Statuses: 1 = Pending, 2 = In Progress, 3 = On Hold
            ->count();
    }

    // public function calendarEvents()
    // {
    //     $user = Auth::user();
    //     // Fetch tasks for the authenticated user
    //     $tasks = Tasks::where('employee_id', $user->id)->get();

    //     // Map tasks to events
    //     $events = $tasks->map(function ($task, $index) {
    //         $taskEvents = [];

    //         // Due Task - Check if due today and not completed
    //         if ($task->due_date && Carbon::parse($task->due_date)->isToday() && $task->status != 4) {
    //             $taskEvents[] = [
    //                 'id' => $index + 1, // Unique ID
    //                 'title' => 'Due: ' . $task->task_name,
    //                 'date' => Carbon::parse($task->due_date)->toDateString(),
    //                 'className' => 'bg-red-500 border-0', // Highlighted for due tasks
    //             ];
    //         }

    //         // Completed Task
    //         if ($task->status == 4) {
    //             $taskEvents[] = [
    //                 'id' => $index + 2, // Unique ID
    //                 'title' => 'Completed: ' . $task->task_name,
    //                 'date' => Carbon::parse($task->complete_date)->toDateString(),
    //                 'className' => 'bg-green-500 border-0', // Green for completed tasks
    //             ];
    //         }

    //         // Pending Task - For future due dates
    //         if ($task->status == 1 && Carbon::parse($task->due_date)->isFuture()) {
    //             $taskEvents[] = [
    //                 'id' => $index + 3, // Unique ID
    //                 'title' => 'Pending: ' . $task->task_name,
    //                 'date' => Carbon::parse($task->due_date)->toDateString(),
    //                 'className' => 'bg-yellow-500 border-0', // Yellow for pending tasks
    //             ];
    //         }

    //         // In Progress Task
    //         if ($task->status == 2) {
    //             $taskEvents[] = [
    //                 'id' => $index + 4, // Unique ID
    //                 'title' => 'In Progress: ' . $task->task_name,
    //                 'date' => Carbon::parse($task->updated_at)->toDateString(),
    //                 'className' => 'bg-blue-500 border-0', // Blue for in-progress tasks
    //             ];
    //         }

    //         // On Hold Task
    //         if ($task->status == 3) {
    //             $taskEvents[] = [
    //                 'id' => $index + 5, // Unique ID
    //                 'title' => 'On Hold: ' . $task->task_name,
    //                 'date' => Carbon::parse($task->updated_at)->toDateString(),
    //                 'className' => 'bg-gray-500 border-0', // Gray for on-hold tasks
    //             ];
    //         }

    //         return $taskEvents; // Return events for this task
    //     })->flatten(1)->values()->toArray(); // Flatten, re-index, and convert to array

    //     return $events; // Return the prepared events
    // }


    public function calendarEvents()
    {
        $user = Auth::user();
        $tasks = Tasks::where('employee_id', $user->id)->get();

        $events = $tasks->map(function ($task, $index) {
            $taskEvents = [];
            $dueDate = Carbon::parse($task->due_date);

            // Overdue Task - Due yesterday and still pending
            if ($dueDate->isYesterday() && !in_array($task->status, [2, 3, 4])) {
                $taskEvents[] = [
                    'id' => $index + 10, // Unique ID
                    'title' => 'Overdue: ' . $task->task_name,
                    'date' => $dueDate->toDateString(),
                    'className' => 'bg-red-500 border-0', // Dark red for overdue tasks
                ];
            }

            // Due Task - Due today and not completed
            if ($dueDate->isToday() && $task->status != 4) {
                $taskEvents[] = [
                    'id' => $index + 1,
                    'title' => 'Due: ' . $task->task_name,
                    'date' => $dueDate->toDateString(),
                    'className' => 'bg-red-500 border-0',
                ];
            }

            // Completed Task
            if ($task->status == 4) {
                $taskEvents[] = [
                    'id' => $index + 2,
                    'title' => 'Completed: ' . $task->task_name,
                    'date' => Carbon::parse($task->complete_date)->toDateString(),
                    'className' => 'bg-green-500 border-0',
                ];
            }

            // Pending Task - For future due dates
            if ($task->status == 1 && $dueDate->isFuture()) {
                $taskEvents[] = [
                    'id' => $index + 3,
                    'title' => 'Pending: ' . $task->task_name,
                    'date' => $dueDate->toDateString(),
                    'className' => 'bg-yellow-500 border-0',
                ];
            }

            // In Progress Task
            if ($task->status == 2) {
                $taskEvents[] = [
                    'id' => $index + 4,
                    'title' => 'In Progress: ' . $task->task_name,
                    'date' => Carbon::parse($task->updated_at)->toDateString(),
                    'className' => 'bg-blue-500 border-0',
                ];
            }

            // On Hold Task
            if ($task->status == 3) {
                $taskEvents[] = [
                    'id' => $index + 5,
                    'title' => 'On Hold: ' . $task->task_name,
                    'date' => Carbon::parse($task->updated_at)->toDateString(),
                    'className' => 'bg-gray-500 border-0',
                ];
            }

            return $taskEvents;
        })->flatten(1)->values()->toArray();

        return $events;
    }


    public function render()
    {
        return view('livewire.dashboard.user-dashboard');
    }
}
