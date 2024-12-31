<?php

namespace App\Livewire\Dashboard;

use App\Mail\ReminderMail;
use App\Models\Employee;
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
    public $myTasks;
    public $completed;
    public $incompleted;
    public $totalcompleted;
    public $totalincompleted;
    public $users;
    public $chartData = [];

    public $confirm = false;
    public $selectedUserId;



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
    }


    public function openModal($userId)
    {
        $this->selectedUserId = $userId;
        $this->confirm = true; // Show the modal
    }


    public function sendReminder()
    {
        // Find the user by ID
        $user = User::findOrFail($this->selectedUserId);

        // Define the reminder content
        $messageContent = "Hello {$user->name}, this is a reminder about your pending tasks.";

        // Send the email
        Mail::to($user->email)->send(new ReminderMail($messageContent));
        $this->confirm = false; // Show the modal
        // Notify the user that the email was sent successfully
        // Toast
        $this->toast(
            type: 'success',
            title: 'Sended!',
            description: "Reminder email sent to {$user->email}!",                  // optional (text)
            position: 'toast-top toast-end',    // optional (daisyUI classes)
            icon: 'o-check-circle',       // Optional (any icon)
            css: 'alert-success',                  // Optional (daisyUI classes)
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

        // Get the tasks assigned to the authenticated user
        $this->myTasks = Tasks::where('employee_id', $user->id)->get(); // Fetch tasks assigned to the current user

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
                'myTasks' => $this->myTasks,
                'completed' => $this->completed,
                'incompleted' => $this->incompleted,
                'chartData' => $this->chartData,
                'tasks' => $tasks,
                'totalCount' => $totalCount,
            ]
        );
    }
}
