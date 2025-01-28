<?php

namespace App\Livewire\Dashboard;

use App\Mail\ReminderMail;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Mary\Traits\Toast;

class Dashboard extends Component
{

    use Toast;
    public $adminCount;
    public $employeeCount;
    public $taskCount;
    public $mytaskCount;
    public $completed;
    public $incompleted;
    public $totalcompleted;
    public $totalincompleted;
    public $users;
    public $chartData = [];
    public $events = [];


    public $confirm = false;
    public $selectedUserId;
    public $tasksForReminder;



    public function mount()
    {

        $completed = Tasks::where('status', 4)->count();
        $incompleted = Tasks::whereIn('status', [1, 2, 3])->count();
        $pending = Tasks::where('status', 1)->count();
        $inProgress = Tasks::where('status', 2)->count();
        $onHold = Tasks::where('status', 3)->count();

        $this->chartData = [
            'labels' => ['Completed', 'Incompleted', 'Pending', 'In Progress', 'On Hold'],
            'series' => [$completed, $incompleted, $pending, $inProgress, $onHold],
        ];

        // Call the function to prepare the events
        // Fetch and assign events
        $this->events = $this->calendarEvents();

        // Debugging
        // dd($this->events);
    }

    public function calendarEvents()
    {
        $user = Auth::user();

        // Fetch tasks for the authenticated user
        $tasks = Tasks::where('employee_id', $user->id)->get();

        // Map tasks to events
        $events = $tasks->map(function ($task, $index) {
            $taskEvents = [];

            // Get today's date for comparison
            $today = Carbon::today();

            // Due Task - Check if due today and not completed
            if ($task->due_date && Carbon::parse($task->due_date)->isToday() && $task->status != 4) {
                $taskEvents[] = [
                    'id' => $index + 1, // Unique ID
                    'title' => 'Due: ' . $task->task_name,
                    'date' => Carbon::parse($task->due_date)->toDateString(),
                    'className' => 'bg-red-500 border-0', // Highlighted for due tasks
                ];
            }

            // Completed Task
            if ($task->status == 4) {
                $taskEvents[] = [
                    'id' => $index + 2, // Unique ID
                    'title' => 'Completed: ' . $task->task_name,
                    'date' => Carbon::parse($task->complete_date)->toDateString(),
                    'className' => 'bg-green-500 border-0', // Green for completed tasks
                ];
            }

            // Pending Task - For future due dates
            if ($task->status == 1 && Carbon::parse($task->due_date)->isFuture()) {
                $taskEvents[] = [
                    'id' => $index + 3, // Unique ID
                    'title' => 'Pending: ' . $task->task_name,
                    'date' => Carbon::parse($task->due_date)->toDateString(),
                    'className' => 'bg-yellow-500 border-0', // Yellow for pending tasks
                ];
            }

            // In Progress Task
            if ($task->status == 2) {
                $taskEvents[] = [
                    'id' => $index + 4, // Unique ID
                    'title' => 'In Progress: ' . $task->task_name,
                    'date' => Carbon::parse($task->updated_at)->toDateString(),
                    'className' => 'bg-blue-500 border-0', // Blue for in-progress tasks
                ];
            }

            // On Hold Task
            if ($task->status == 3) {
                $taskEvents[] = [
                    'id' => $index + 5, // Unique ID
                    'title' => 'On Hold: ' . $task->task_name,
                    'date' => Carbon::parse($task->updated_at)->toDateString(),
                    'className' => 'bg-gray-500 border-0', // Gray for on-hold tasks
                ];
            }

            return $taskEvents; // Return events for this task
        })->flatten(1)->values()->toArray(); // Flatten, re-index, and convert to array

        return $events; // Return the prepared events
    }



    public function openModal($userId)
    {
        $this->selectedUserId = $userId;

        // Get tasks for the selected employee with today's due date
        $today = Carbon::today();
        $this->tasksForReminder = Tasks::with('employee') // Include the project relation if needed
            ->where('employee_id', $userId)
            ->whereDate('due_date', $today)
            ->get();
        $this->confirm = true; // Show the modal
    }

    public function sendReminder()
    {
        // Find the user by ID
        $user = User::findOrFail($this->selectedUserId);
        // Ensure tasks for this user exist
        if ($this->tasksForReminder->isEmpty()) {
            $this->toast(
                type: 'error',
                title: 'Error!',
                description: 'No tasks due today for this employee.',
                position: 'toast-top toast-end',
                icon: 'o-alert-circle',
                css: 'alert-error',
                redirectTo: null
            );
            return;
        }

        // Prepare task details for the email
        $taskDetails = $this->tasksForReminder->map(function ($task) {
            return [
                'task_name' => $task->task_name,
                'area' => $task->area,
                'project_name' => $task->project_name,
                'created_at' => $task->created_at,
                'due_date' => $task->due_date,
            ];
        })->toArray();

        // Send the email
        Mail::to($user->email)->send(new ReminderMail($user->name, $taskDetails));

        $this->confirm = false; // Close the modal

        // Notify the user
        $this->toast(
            type: 'success',
            title: 'Sent!',
            description: "Reminder email sent to {$user->email}!",
            position: 'toast-top toast-end',
            icon: 'o-check-circle',
            css: 'alert-info',
            redirectTo: null
        );
    }


    public function render()
    {
        // Get today's date
        $today = Carbon::today();

        // Get tasks where the due_date is today
        $tasks = Tasks::with('employee') // Eager load the related user (employee)
            ->whereDate('due_date', $today) // Filter tasks with today's due date
            ->get();
        // Get total count of tasks for today
        $totalCount = $tasks->count();

        // Get all users with their associated tasks

        $role = Auth::user()->role_id;
        // Get the authenticated user
        $user = Auth::user();
        // Count the total number of Admins and Employees
        $this->adminCount = User::where('role_id', 1)->count();
        $this->employeeCount = User::where('role_id', 2)->count();
        $this->taskCount = Tasks::count();
        // Count total completed tasks across the system
        $this->totalcompleted = Tasks::where('status', 4)->count();

        // Count total incomplete tasks across the system
        $this->totalincompleted = Tasks::whereIn('status', [1, 2, 3])->count();
        // Count the number of tasks assigned to the authenticated user
        $this->mytaskCount = Tasks::where('employee_id', $user->id)->count();

        $this->completed = Tasks::where('employee_id', $user->id)
            ->where('status', 4)
            ->count();
        // Count incomplete tasks (all statuses except 4)
        $this->incompleted = Tasks::where('employee_id', $user->id)
            ->whereIn('status', [1, 2, 3]) // Statuses: 1 = Pending, 2 = In Progress, 3 = On Hold
            ->count();

        return view(
            'livewire.dashboard.dashboard',
            [
                'role' => $role,
                'adminCount' => $this->adminCount,
                'employeeCount' => $this->employeeCount,
                'taskCount' => $this->taskCount,
                'totalcompleted' => $this->totalcompleted,
                'totalincompleted' => $this->totalincompleted,
                'mytaskCount' => $this->mytaskCount,
                'completed' => $this->completed,
                'incompleted' => $this->incompleted,
                'chartData' => $this->chartData,
                'tasks' => $tasks,
                'totalCount' => $totalCount,
            ]
        );
    }
}
