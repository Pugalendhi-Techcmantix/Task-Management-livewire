<?php

namespace App\Livewire\Dashboard;

use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Omnia\LivewireCalendar\LivewireCalendar;

class SampleCalendar extends LivewireCalendar
{

    // public function events(): Collection
    // {
    //     // must return a Laravel collection
    //     // Return a Collection of events with title, start, and end dates
    //     return collect([
    //         [
    //             'id' => 1,
    //             'title' => 'Sample Appointment',
    //             'description' => 'This is a test appointment',
    //             'date' => now()->format('Y-m-d'),
    //         ],
    //     ]);
    // }



    public function events(): Collection
    {
        $user = Auth::user();

        // Fetch tasks for the authenticated user
        $tasks = Tasks::where('employee_id', $user->id)->get();

        // Initialize an empty collection for events
        $events = collect();

        foreach ($tasks as $task) {
            // Handle Due Date (Red color)
            if ($task->due_date) {
                $dueDate = Carbon::parse($task->due_date); // Parse due date
                $events->push([
                    'id' => $task->id,
                    'title' => 'Due Task: ' . $task->task_name,
                    'description' => $task->task_name,
                    'date' => $dueDate->format('Y-m-d'),
                ]);
            }

            // Handle Completed Date (Green color)
            if ($task->complete_date) {
                $completeDate = Carbon::parse($task->complete_date); // Parse complete date
                $events->push([
                    'id' => $task->id,
                    'title' => 'Completed Task: ' . $task->task_name,
                    'description' => $task->task_name,
                    'date' => $completeDate->format('Y-m-d'),
                ]);
            }
        }

        // Return the events collection
        return $events;
    }
    // public function render()
    // {
    //     return view('livewire.dashboard.sample-calendar');
    // }
}
