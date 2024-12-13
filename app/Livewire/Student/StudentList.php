<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class StudentList extends Component
{
    use WithPagination;
    public string $search = ''; // Search query
    public bool $confirmDelete = false;
    public $student_id;
    public int $perPage = 5; // Number of items per page
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public function addForm()
    {

        return redirect()->route('student-add');
    }

    public function editStudent($student_id)
    {   
        // info($student_id);
        $this->student_id = $student_id;
        return redirect()->route('student-edit', $this->student_id);
    }

    public function openDeleteModal($student_id)
    {
        $this->confirmDelete = true;    // Trigger modal visibility
        $this->student_id = $student_id; // Assign the student ID to delete

    }
    public function destroy()
    {
        // Deleting the student record
        Student::findOrFail($this->student_id)->delete();
        $this->confirmDelete = false;
    }


    public function render()
    {
        $headers = [
            ['key' => 'id', 'label' => 'S.No', 'sortable' => true,'class' => 'w-20'],
            ['key' => 'name', 'label' => 'Name', 'sortable' => true],
            ['key' => 'rollno', 'label' => 'RollNo', 'sortable' => true],
            ['key' => 'age', 'label' => 'Age', 'sortable' => true],
            ['key' => 'actions', 'label' => 'Action', 'sortable' => false],
        ];
        // Fetch students with sorting
        $students = Student::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('rollno', 'like', '%' . $this->search . '%')
            ->orWhere('age', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);

        return view('livewire.student.student-list', [
            'students' => $students,
            'headers' => $headers,
        ]);
    }
}


// $students = Student::all();
        // Filter students based on the search query
        // $students = Student::query()
        //     ->where('name', 'like', '%' . $this->search . '%')
        //     ->orWhere('rollno', 'like', '%' . $this->search . '%')
        //     ->orWhere('age', 'like', '%' . $this->search . '%')
        //     ->orderBy('id')
        //     ->paginate(2);
