<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class EmployeeList extends Component
{
    use Toast;
    use WithPagination;
    public string $search = ''; // Search query
    public bool $confirmOpen = false;
    public bool $confirmDelete = false;
    public $employee_id = null; // Employee ID for update operations
    public int $perPage = 10; // Number of items per page
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public  $name = null; // Employee name
    public  $email = null; // Employee email
    public  $age = null; // Employee age
    public  $position = null; // Employee position
    public $salary = null; // Employee salary
    public  $joining_date = null; // Employee joining date

    protected $listeners = ['refresh-employee-table' => '$refresh'];


    public function openModal()
    {
        $this->confirmOpen = true;    // Trigger modal visibility
    }

    public function openDeleteModal($employee_id)
    {
        $this->confirmDelete = true;    // Trigger modal visibility
        $this->employee_id = $employee_id; // Assign the employee ID to delete
    }
    public function destroy()
    {
        // Deleting the Employee record
        User::findOrFail($this->employee_id)->delete();
        $this->confirmDelete = false;
        $this->dispatch('refresh-employee-table');
        $this->toast(
            type: 'success',
            title: 'Deleted!',
            description: 'Deleted successfully.',
            position: 'toast-top toast-end',
            icon: 'o-check-circle',
            css: 'alert-success',
        );
    }
    public function render()
    {
        $headers = [
            ['key' => 'id', 'label' => 'S.No', 'sortable' => true, 'class' => 'w-20'],
            ['key' => 'name', 'label' => 'Name', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'email', 'label' => 'Email', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'age', 'label' => 'Age', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'role.name', 'label' => 'Role', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'position', 'label' => 'Position', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'salary', 'label' => 'Salary', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'status', 'label' => 'Status', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'joining_date', 'label' => 'D.O.J', 'format' => ['date', 'd-m-Y'], 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'actions', 'label' => 'Action', 'sortable' => false],
        ];
        // Fetch students with sorting
        $employees = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('age', 'like', '%' . $this->search . '%')
                    ->orWhereHas('role', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('position', 'like', '%' . $this->search . '%')
                    ->orWhere('salary', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('joining_date', 'like', '%' . $this->search . '%');
            })
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
