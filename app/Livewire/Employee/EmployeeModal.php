<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class EmployeeModal extends ModalComponent
{

    use WithFileUploads;  // Ensure file uploads are handled in the modal
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
        return 'md';
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
