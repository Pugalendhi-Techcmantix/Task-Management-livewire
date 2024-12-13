<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Livewire\Component;

class StudentAdd extends Component
{

    public $name, $rollno, $age;
    public function submit()
    {

        // Validate the form data
        $this->validate([
            'name' => 'required|string|max:255',
            'rollno' => 'required|integer|unique:students,rollno',
            'age' => 'required|integer|min:1|max:100',
        ]);

        // Create a new student record
        Student::create([
            'name' => $this->name,
            'rollno' => $this->rollno,
            'age' => $this->age,
        ]);

        // Clear the input fields
        $this->reset();

        // Redirect or emit a success message
        // session()->flash('success', 'Student registered successfully!');
        // Redirect to the student list page with a success message
        return redirect()->route('student-add')->with('success', 'Student registered successfully!');
    }
    public function back()
    {
        return redirect()->route('student-list');
    }
    public function render()
    {
        return view('livewire.student.student-add');
    }
}
