<?php

namespace App\Livewire\Employee;

use App\Models\Employee;

use LivewireUI\Modal\ModalComponent;

class EmployeeModal extends ModalComponent
{

    public EmployeeForm $form;

    public function mount($employee_id = null)
    {
        if (!is_null($employee_id)) {
            $employee = Employee::findOrFail($employee_id);
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
