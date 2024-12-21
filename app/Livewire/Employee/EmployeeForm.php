<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Form;

class EmployeeForm extends Form
{
    public ?Employee $employee;
    public ?int $employee_id = null;  // ID of the employee to update
    public  $name = null; // Employee name
    public  $email = null; // Employee email
    public  $age = null; // Employee age
    public  $position = null; // Employee position
    public $salary = null; // Employee salary
    public  $joining_date = null; // Employee joining date
    public ?string $success_message = null;
    public ?string $error_message = null;

    public function updating()
    {
        return !empty($this->employee);
    }
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $this->employee_id,
            'age' => 'required|integer|min:18|max:100',
            'position' => 'required|string|max:255',
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
            'joining_date' => $employee->joining_date,
        ]);
    }

    public function create()
    {
        Employee::create([
            'name' => $this->name,
            'email' => $this->email,
            'age' => $this->age,
            'position' => $this->position,
            'salary' => $this->salary,
            'joining_date' => $this->joining_date,
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
        ]);
        $this->success_message = "Employee updated successfully!";
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
        return view('livewire.employee.employee-form');
    }
}
