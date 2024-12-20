<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Exception;
use Livewire\Component;
use Livewire\Form;
use Livewire\WithFileUploads;

class EmployeeForm extends Form
{
    use  WithFileUploads;
    public ?Employee $employee;
    public ?int $employee_id = null;  // ID of the employee to update
    public  $name = null; // Employee name
    public  $email = null; // Employee email
    public  $age = null; // Employee age
    public  $position = null; // Employee position
    public $salary = null; // Employee salary
    public  $joining_date = null; // Employee joining date
    public $profile_image = null; // File for avatar upload
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
            'email' => 'required|email|unique:employees,email',
            'age' => 'required|integer|min:18|max:100',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'profile_image' => 'nullable|file|mimes:jpg,png|max:2048',
        ];
    }

    public function setValue(Employee $employee)
    {
        $this->employee = $employee;
        $this->fill([
            'name' => $employee->name,
            'email' => $employee->email,
            'age' => $employee->age,
            'position' => $employee->position,
            'salary' => $employee->salary,
            'joining_date' => $employee->joining_date,
            'profile_image' => $employee->profile_image,
        ]);
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
    public function update()
    {
        // Validate the form fields
        $validatedData = $this->validate();
        // Check if profile image is uploaded and store it
        if ($this->profile_image) {
            // Store the file and get the file path
            $validatedData['profile_image'] = $this->profile_image->store('profile_images', 'public');
        }
        $this->employee->update($validatedData);
        $this->success_message = "Employee updated successfully!";
    }

    public function create()
    {
        // Validate the form fields
        $validatedData = $this->validate();
        // Check if profile image is uploaded and store it
        if ($this->profile_image) {
            // Store the file and get the file path
            $validatedData['profile_image'] = $this->profile_image->store('profile_images', 'public');
        }
        // Create a new employee record with the validated data
        Employee::create($validatedData);
        $this->success_message = "Employee created successfully!";
    }
    public function render()
    {
        return view('livewire.employee.employee-form');
    }
}
