<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Ramsey\Uuid\Type\Integer;

class EmployeeList extends Component
{
    use Toast;
    use WithPagination, WithFileUploads;
    public string $search = ''; // Search query
    public bool $confirmOpen = false;
    public bool $confirmDelete = false;
    public $editEmployee = null; // Track the employee being edited
    public $employee_id = null; // Employee ID for update operations
    public int $perPage = 5; // Number of items per page
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public  $name = null; // Employee name
    public  $email = null; // Employee email
    public  $age = null; // Employee age
    public  $position = null; // Employee position
    public $salary = null; // Employee salary
    public  $joining_date = null; // Employee joining date
    public $profile_image = null; // File for avatar upload

    protected $listeners = ['refresh-employee-table' => '$refresh'];


    public function openModal()
    {
        $this->confirmOpen = true;    // Trigger modal visibility
    }



    // public function submit()
    // {
    //     // Validate the input data
    //     $validatedData = $this->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:employees,email',
    //         'age' => 'required|integer|min:18|max:100',
    //         'position' => 'required|string|max:255',
    //         'salary' => 'required|numeric|min:0',
    //         'joining_date' => 'required|date',
    //         'profile_image' => 'nullable|file|mimes:jpg,png|max:2048', // File validation
    //     ]);
    //     // Handle file upload
    //     if ($this->profile_image) {
    //         $validatedData['profile_image'] = $this->profile_image->store('profile_images', 'public');
    //     }
    //     // Create new employee
    //     Employee::create($validatedData);
    //     session()->flash('success', 'Employee added successfully!');
    //     // Reset input fields and close the modal
    //     $this->resetInputFields();
    // }
    public function submit()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . ($this->editEmployee ? $this->editEmployee->id : ''),
            'age' => 'required|integer|min:18|max:100',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'profile_image' => 'nullable|file|mimes:jpg,png|max:2048',
        ]);

        if ($this->profile_image) {
            $validatedData['profile_image'] = $this->profile_image->store('profile_images', 'public');
        }

        if ($this->editEmployee) {
            // Update the employee
            $this->editEmployee->update($validatedData);
            session()->flash('success', 'Employee updated successfully!');
        } else {
            // Create a new employee
            Employee::create($validatedData);
            session()->flash('success', 'Employee added successfully!');
        }

        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->age = '';
        $this->position = '';
        $this->salary = '';
        $this->joining_date = '';
        $this->profile_image = null;
        $this->employee_id = null;
    }

    public function openDeleteModal($employee_id)
    {
        $this->confirmDelete = true;    // Trigger modal visibility
        $this->employee_id = $employee_id; // Assign the employee ID to delete
    }
    public function destroy()
    {
        // Deleting the Employee record
        Employee::findOrFail($this->employee_id)->delete();
        $this->confirmDelete = false;
        $this->dispatch('refresh-employee-table');
        $this->success("Deleted Successfully");
    }
    public function render()
    {

        $headers = [
            ['key' => 'id', 'label' => 'S.No', 'sortable' => true, 'class' => 'w-20'],
            ['key' => 'name', 'label' => 'Name', 'sortable' => true],
            ['key' => 'email', 'label' => 'Email', 'sortable' => true],
            ['key' => 'age', 'label' => 'Age', 'sortable' => true],
            ['key' => 'position', 'label' => 'Position', 'sortable' => true],
            ['key' => 'salary', 'label' => 'Salary', 'sortable' => true],
            ['key' => 'joining_date', 'label' => 'D.O.J', 'format' => ['date', 'd-m-Y'], 'sortable' => true],
            ['key' => 'actions', 'label' => 'Action', 'sortable' => false],
        ];
        // Fetch students with sorting
        $employees = Employee::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('age', 'like', '%' . $this->search . '%')
            ->orWhere('position', 'like', '%' . $this->search . '%')
            ->orWhere('salary', 'like', '%' . $this->search . '%')
            ->orWhere('joining_date', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);

        return view(
            'livewire.employee.employee-list',
            [
                'headers' => $headers,
                'employees' => $employees,
            ]
        );
    }
}
