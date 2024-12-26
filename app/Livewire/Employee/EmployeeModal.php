<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\Roles;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class EmployeeModal extends ModalComponent
{

    public EmployeeForm $form;
    public $statusOptions = [
        [
            'id' => 1,
            'name' => 'Active',
        ],
        [
            'id' => 2,
            'name' => 'Suspended',

        ],
    ];

    public $roles = [];  // Store roles here as key-value pairs

    public function mount($employee_id = null)
    {

        // Fetch roles from the roles table and store them in $roles array
        $this->roles = Roles::all()->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
            ];
        })->toArray();

        if (!is_null($employee_id)) {
            $employee = User::findOrFail($employee_id);
            $this->form->setValue($employee);
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
        $this->dispatch('refresh-employee-table');
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
        return view('livewire.employee.employee-modal');
    }
}
