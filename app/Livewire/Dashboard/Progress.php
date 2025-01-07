<?php

namespace App\Livewire\Dashboard;

use App\Models\Tasks;
use Carbon\Carbon;
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



    // public function updateTaskStatus()
    // {
    //     $task = Tasks::find($this->selectedTaskId);
    //     if ($task && $task->employee_id === Auth::id()) {
    //         $task->status = $this->selectedStatus;

    //         $task->save();

    //         // Update local task list
    //         $this->myTasks = $this->myTasks->map(function ($t) {
    //             if ($t->id === $this->selectedTaskId) {
    //                 $t->status = $this->selectedStatus;
    //                 if ($this->selectedStatus == 3) {
    //                     $t->complete_date = Carbon::now()->format('Y-m-d');
    //                 } else {
    //                     $t->complete_date = null;
    //                 }
    //             }
    //             return $t;
    //         });

    //         $this->dispatch('refresh-progress'); // Notify frontend
    //     }
    //     $this->confirm = false; // Close the modal
    // }

    // public function updateTaskStatus()
    // {
    //     $task = Tasks::find($this->selectedTaskId);
    //     if ($task && $task->employee_id === Auth::id()) {
    //         $task->status = $this->selectedStatus;

    //         // Update complete_date if status is "completed"
    //         if ($this->selectedStatus == 3) { // Assuming "3" is the "completed" status
    //             $task->complete_date = Carbon::now()->format('Y-m-d'); // Set today's date
    //         } else {
    //             $task->complete_date = null; // Clear the complete_date if not completed
    //         }
    //         $task->save(); // Save changes to the database

    //         $this->dispatch('refresh-progress'); // Notify frontend
    //     }
    //     $this->confirm = false; // Close the modal
    // }

    public function updateTaskStatus()
    {

        // Debugging the selected task ID, status, and complete_date
        // dd([
        //     'selectedTaskId' => $this->selectedTaskId,
        //     'selectedStatus' => $this->selectedStatus,
        //     'complete_date' => ($this->selectedStatus == 4) ? Carbon::now()->format('Y-m-d') : null,
        // ]);
        // Update the task status and complete_date in a single query
        $taskUpdated = Tasks::where('id', $this->selectedTaskId)
            ->where('employee_id', Auth::id()) // Ensure the task belongs to the authenticated user
            ->update([
                'status' => $this->selectedStatus,
                'complete_date' => ($this->selectedStatus == 4) ? Carbon::now()->format('Y-m-d') : null, // Set today's date if completed, else null
            ]);

        // Check if the update was successful
        if ($taskUpdated) {
            $this->dispatch('refresh-progress'); // Notify frontend if update is successful
        }

        $this->confirm = false; // Close the modal
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
