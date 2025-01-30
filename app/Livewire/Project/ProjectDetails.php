<?php

namespace App\Livewire\Project;

use App\Models\Tasks;
use App\Models\User;
use Livewire\Component;

class ProjectDetails extends Component
{
    public $projects = []; // Store all project details
    public $selectedTab; // Store selected tab
    public $projectNames = []; // Store project names for tabs

    public bool $showDrawer1 = false;
    public $selectedUserTasks = []; // Store tasks of selected user
    public $selectedUser = null; // Store selected user name

    public $statusLabels = [
        1 => 'Pending',
        2 => 'Progress',
        3 => 'Hold',
        4 => 'Completed',
    ];

    public function mount()
    {
        // Get all unique project names from tasks table
        $this->projectNames = Tasks::pluck('project_name')->unique();
        // Loop through each project name and fetch its details
        foreach ($this->projectNames as $projectName) {
            // Get total tasks for this project
            $totalTasks = Tasks::where('project_name', $projectName)->count();

            // Get completed tasks (Status = 4)
            $completedTasks = Tasks::where('project_name', $projectName)
                ->where('status', 4)
                ->count();

            // Get all employee IDs assigned to this project
            $employeeIds = Tasks::where('project_name', $projectName)->pluck('employee_id');

            // Fetch user names based on employee IDs
            $users = User::whereIn('id', $employeeIds)->pluck('name');

            // Calculate progress (percentage of completed tasks)
            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            // Store project details
            $this->projects[$projectName] = [
                'name' =>  $projectName,
                'totalTasks' => $totalTasks,
                'totalEmployees' => $users->count(),
                'users' => $users,
                'progress' => round($progress, 2), // Rounded progress percentage
            ];
        }
    }

    public function loadUserTasks($projectName, $userName)
    {
        $user = User::where('name', $userName)->first();
        if (!$user) return;

        // Fetch tasks for selected user in the given project
        $this->selectedUserTasks = Tasks::where('project_name', $projectName)
            ->where('employee_id', $user->id)
            ->get();

        $this->selectedUser = $userName;
        $this->showDrawer1 = true; // Open the drawer
    }
    public function render()
    {
        // $firstTab = Tasks::where('id', 1)->first();
        // $this->selectedTab = $firstTab->project_name . '-tab';
        if (!$this->selectedTab) { // ✅ Only set if empty
            $firstTab = Tasks::where('id', 1)->first();
            $this->selectedTab = $firstTab->project_name . '-tab';
        }
        return view('livewire.project.project-details');
    }
}
