<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Livewire\Component;

class StudentEdit extends Component
{
    public $student;
    public $student_id, $name, $rollno, $age;

    // Mount method to load student data based on the passed student_id
    public function mount($student_id)
    {
        $this->student_id = $student_id;
        $student = Student::find($student_id);

        // Check if student exists
        if ($student) {
            // Initialize form fields with student data
            $this->name = $student->name;
            $this->rollno = $student->rollno;
            $this->age = $student->age;
        } else {
            session()->flash('error', 'Student not found!');
            return redirect()->route('student-list'); // Redirect to student list if student not found
        }
    }

    public function update()
    {
        // Validate the form data
        $this->validate([
            'name' => 'required|string|max:255',
            'rollno' => "required|integer|unique:students,rollno,{$this->student_id}",
            'age' => 'required|integer|min:1|max:100',
        ]);
        // Find the student by ID
        $student = Student::find($this->student_id);
        // Find the student and update
        if ($student) {
            // Update student data
            $student->update([
                'name' => $this->name,
                'rollno' => $this->rollno,
                'age' => $this->age,
            ]);
            // Emit success message after update
            session()->flash('success', 'Student Updated successfully!');
            // Redirect to the student edit page with the student ID
            return redirect()->route('student-edit', ['id' => $this->student_id]);
        } else {
            session()->flash('error', 'Student not found!');
        }

        // Optionally, you can redirect after successful update
        return redirect()->route('student-edit');
    }

    public function back()
    {
        return redirect()->route('student-list');
    }

    public function render()
    {

        return view('livewire.student.student-edit');
    }
}
