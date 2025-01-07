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
    public $events;

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

        $this->events = [
            [
                'label' => 'Day off',
                'description' => 'Playing <u>tennis.</u>',
                'css' => '!bg-amber-200',
                'date' => now()->startOfMonth()->addDays(3),
            ],
            [
                'label' => 'Event at same day',
                'description' => 'Hey there!',
                'css' => '!bg-amber-200',
                'date' => now()->startOfMonth()->addDays(3),
            ],
            [
                'label' => 'Laracon',
                'description' => 'Let`s go!',
                'css' => '!bg-blue-200',
                'range' => [now()->startOfMonth()->addDays(13), now()->startOfMonth()->addDays(15)],
            ],
        ];
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
