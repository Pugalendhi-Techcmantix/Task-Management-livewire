<?php

namespace App\Livewire\Employee;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Form;

class EmployeeForm extends Form
{
    public ?User $employee;
    public ?int $employee_id = null;  // ID of the employee to update
    public  $name; // Employee name
    public  $email; // Employee email
    public  $password; // Employee password
    public  $age; // Employee age
    public  $position; // Employee position
    public $salary; // Employee salary
    public $status;
    public $role_id;
    public  $joining_date; // Employee joining date

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->employee_id,
            'password' => 'required|string|min:4',
            'age' => 'required|integer|min:18|max:100',
            'position' => 'required|string|max:255',
            'role_id' => 'required',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
        ];
    }

    public function setValue(User $employee)
    {
        $this->employee = $employee;
        $this->employee_id = $employee->id;
        $this->fill([
            'name' => $employee->name,
            'email' => $employee->email,
            'password' => Hash::make($employee->password), // Encrypt the password
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
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password), // Encrypt the password
            'age' => $this->age,
            'position' => $this->position,
            'salary' => $this->salary,
            'role_id' => $this->role_id,
            'joining_date' => $this->joining_date,
            'status' => 2, // Default to Active on create
        ]);
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
