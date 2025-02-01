<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
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
    public $intime;
    public $outtime;
    public $role_id;
    public  $joining_date; // Employee joining date
    public ?string $success_message;
    public ?string $error_message;


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
            // 'intime' => 'nullable|string',
            // 'outtime' => 'nullable|string',
        ];
    }

    public function setValue(User $employee)
    {
        $this->employee = $employee;
        $this->employee_id = $employee->id;
        // Ensure 'time' is decoded if it's not already an array
        $time = is_array($employee->time) ? $employee->time : json_decode($employee->time, true);

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
            'intime' => isset($time['morning']) ? date("H:i", strtotime($time['morning'])) : null,
            'outtime' => isset($time['evening']) ? date("H:i", strtotime($time['evening'])) : null,
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
        $this->success_message = "Employee created successfully!";
    }
    public function update()
    {
        // Convert intime & outtime to JSON format
        $timeData = [
            'morning' => date("h:i A", strtotime($this->intime)), // Convert to AM/PM format
            'evening' => date("h:i A", strtotime($this->outtime)),
        ];
        $this->employee->update([
            'name' => $this->name,
            'email' => $this->email,
            'age' => $this->age,
            'position' => $this->position,
            'salary' => $this->salary,
            'joining_date' => $this->joining_date,
            'status' => $this->status,
            'time' => json_encode($timeData),
        ]);
        $this->success_message = "Employee updated successfully!";
        info($this->all());
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
