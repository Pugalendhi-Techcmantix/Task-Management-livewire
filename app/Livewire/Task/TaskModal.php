<?php

namespace App\Livewire\Task;

use App\Models\Employee;
use App\Models\Roles;
use App\Models\Tasks;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class TaskModal extends ModalComponent
{

    public TaskForm $form;

    public $statusOptions = [
        [
            'id' => 1,
            'name' => 'Pending',
        ],
        [
            'id' => 2,
            'name' => 'Progress',
        ],
        [
            'id' => 3,
            'name' => 'Hold',
        ],
        [
            'id' => 4,
            'name' => 'Completed',
        ],
    ];

    public $employee = [];  // Store only regular employees here as key-value pairs
    public function mount($task_id = null)
    {

        // Fetch the admin role ID
        $adminRole = Roles::where('name', 'Admin')->first();
        if ($adminRole) {
            $this->employee = User::where('role_id', '!=', $adminRole->id)->get()->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                ];
            })->toArray();
        }
        if (!is_null($task_id)) {
            $task = Tasks::findOrFail($task_id);
            $this->form->setValue($task);
        }
    }


    protected function rules()
    {
        return $this->form->rules();
    }

    public function cancel()
    {
        return $this->closeModal();
    }

    public function save()
    {
        // Example save logic (you can modify according to your needs)
        $this->form->save();
        $this->dispatch('refresh-tasks-table');
        return $this->closeModal();
    }
    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }
    public function render()
    {
        return view('livewire.task.task-modal');
    }
}
