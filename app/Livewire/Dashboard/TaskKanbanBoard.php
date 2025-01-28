<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Collection;
use LivewireKanbanBoard\LivewireKanbanBoard;

class TaskKanbanBoard extends LivewireKanbanBoard
{
    public function statuses(): Collection
    {
        return collect([
            ['id' => 'registered', 'title' => 'Registered'],
            ['id' => 'awaiting_confirmation', 'title' => 'Awaiting Confirmation'],
            ['id' => 'confirmed', 'title' => 'Confirmed'],
            ['id' => 'delivered', 'title' => 'Delivered'],
        ]);
    }

    public function records(): Collection
    {
        return collect([
            ['id' => 'task-1', 'title' => 'Design the login page', 'status' => 'registered'],
            ['id' => 'task-2', 'title' => 'Implement authentication API', 'status' => 'awaiting_confirmation'],
            ['id' => 'task-3', 'title' => 'Write unit tests for user module', 'status' => 'confirmed'],
            ['id' => 'task-4', 'title' => 'Deploy app to staging server', 'status' => 'delivered'],
        ]);
    }

    // public function render()
    // {
    //     return view('livewire.dashboard.task-kanban-board');
    // }
}
