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
    public $chartData = [];
    public $confirm = false;
    public $selectedUserId;
    public $tasksForReminder;
    public $username;
    public $currentTime;
    public $tasks;
    public $totalCount;

    public function mount()
    {
        $this->username = Auth::user()->name;
        $this->updateTime();
        $this->cardsCount();
        $this->chart();
        $this->remainders();
    }

    public function updateTime()
    {
        $this->currentTime = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i:s');
    }

    public function cardsCount()
    {
        // Count the total number of Admins and Employees
        $this->adminCount = User::where('role_id', 1)->count();
        $this->employeeCount = User::where('role_id', 2)->count();
        $this->taskCount = Tasks::count();
    }

    public function chart()
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

    public function remainders()
    {
        $today = Carbon::today();
        // Get tasks where the due_date is today
        $this->tasks = Tasks::with('employee') 
            ->whereDate('due_date', $today) 
            ->get();
        $this->totalCount = $this->tasks->count();
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
        return view('livewire.dashboard.dashboard');
    }
}
