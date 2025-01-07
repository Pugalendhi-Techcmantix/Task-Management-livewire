<?php

namespace App\Livewire\Task;

use App\Models\Tasks;
use Livewire\Component;

class TaskList extends Component
{


    public $search = '', $task_id, $confirmDelete = false;
    public int $perPage = 10; // Number of items per page
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];
    protected $listeners = ['refresh-tasks-table' => '$refresh'];

    public $statusLabels = [
        1 => 'Pending',
        2 => 'Progress',
        3 => 'Hold',
        4 => 'Completed',
    ];

    public function openDeleteModal($task_id)
    {
        $this->confirmDelete = true;    // Trigger modal visibility
        $this->task_id = $task_id; // Assign the employee ID to delete
    }

    public function destroy()
    {
        Tasks::findOrfail($this->task_id)->delete();
        $this->confirmDelete = false;
        $this->dispatch('refresh-role-table');
    }

    public function render()
    {
        $headers = [
            ['key' => 'id', 'label' => 'S.No', 'sortable' => true,],
            ['key' => 'project_name', 'label' => 'Project Name', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'area', 'label' => 'Area', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'task_name', 'label' => 'Task Name', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'employee.name', 'label' => 'Employee', 'sortable' => false, 'class' => 'truncate'],
            ['key' => 'user.name', 'label' => 'Assigned By', 'sortable' => false, 'class' => 'truncate'],
            ['key' => 'due_date', 'label' => 'Due Date ', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'complete_date', 'label' => 'Complete Date ', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'status', 'label' => 'Status', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'created_at', 'label' => 'Created At', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'updated_at', 'label' => 'Updated At', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'actions', 'label' => 'Action', 'sortable' => false],
        ];

        // Query to fetch tasks with the search applied to multiple columns
        $tasks = Tasks::query()
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('project_name', 'like', '%' . $this->search . '%')
                    ->orWhere('area', 'like', '%' . $this->search . '%')
                    ->orWhere('task_name', 'like', '%' . $this->search . '%')
                    ->orWhere('due_date', 'like', '%' . $this->search . '%')
                    ->orWhere('complete_date', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%')
                    ->orWhereHas('employee', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
                // Check for status labels
                foreach ($this->statusLabels as $key => $label) {
                    if (stripos($label, $this->search) !== false) {
                        $query->orWhere('status', $key);
                    }
                }
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
        return view(
            'livewire.task.task-list',
            [
                'headers' => $headers,
                'tasks' => $tasks,
            ]
        );
    }
}
