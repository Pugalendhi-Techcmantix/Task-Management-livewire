<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Form;

class EmployeeForm extends Form
{
    public ?Employee $employee;
    public ?int $employee_id = null;  // ID of the employee to update
    public  $name; // Employee name
    public  $email; // Employee email
    public  $age; // Employee age
    public  $position; // Employee position
    public $salary; // Employee salary
    public $status;
    public $role_id;
    public  $joining_date; // Employee joining date
    public ?string $success_message;
    public ?string $error_message;
    

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $this->employee_id,
            'age' => 'required|integer|min:18|max:100',
            'position' => 'required|string|max:255',
            'role_id' => 'required',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
        ];
    }

    public function setValue(Employee $employee)
    {
        $this->employee = $employee;
        $this->employee_id = $employee->id;
        $this->fill([
            'name' => $employee->name,
            'email' => $employee->email,
            'age' => $employee->age,
            'position' => $employee->position,
            'salary' => $employee->salary,
            'role_id' => $employee->role_id,
            'joining_date' => $employee->joining_date,
            'status' => $employee->status,
        ]);
    }

    public function create()
    {
        // dd($this->all());
        Employee::create([
            'name' => $this->name,
            'email' => $this->email,
            'age' => $this->age,
            'position' => $this->position,
            'salary' => $this->salary,
            'role_id' => $this->role_id,
            'joining_date' => $this->joining_date,
            'status' => 1, // Default to Active on create
        ]);
        $this->success_message = "Employee created successfully!";
    }
    public function update()
    {
        $this->employee->update([
            'name' => $this->name,
            'email' => $this->email,
            'age' => $this->age,
            'position' => $this->position,
            'salary' => $this->salary,
            'joining_date' => $this->joining_date,
            'status' => $this->status,
        ]);
        $this->success_message = "Employee updated successfully!";
    }

    public function updating()
    {
        return !empty($this->employee);
    }
    public function save()
    {
        $this->validate();
        if ($this->updating()) {

            $this->update();
        } else {
            $this->create();
        }
    }
    public function render()
    {
        return view(
            'livewire.employee.employee-form'
        );
    }
}
