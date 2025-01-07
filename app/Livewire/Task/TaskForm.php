<?php

namespace App\Livewire\Task;

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class TaskForm extends Form
{

    public ?Tasks $tasks;
    public ?int $task_id = null;
    public  $project_name;
    public  $area;
    public  $task_name;
    public $status;
    public $employee_id;
    public $due_date;
    public $complete_date;

    public function rules()
    {
        return [
            'project_name' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'task_name' => 'required|string',
            'employee_id' => 'required',
            'due_date' => 'required'
        ];
    }


    public function setValue(Tasks $tasks)
    {
        $this->tasks = $tasks;
        $this->task_id = $tasks->id;
        $this->fill([
            'project_name' => $tasks->project_name,
            'area' => $tasks->area,
            'task_name' => $tasks->task_name,
            'employee_id' => $tasks->employee_id,
            'status' => $tasks->status,
            'due_date' => $tasks->due_date,
            'complete_date' => $tasks->complete_date,
        ]);
    }

    public function create()
    {
        $user_id = Auth::user()->id;
        //  dd($this->all());
        Tasks::create([
            'project_name' => $this->project_name,
            'area' => $this->area,
            'task_name' => $this->task_name,
            'due_date' => $this->due_date,
            'complete_date' => $this->complete_date,
            'employee_id' => $this->employee_id,
            'user_id' => $user_id,
            'status' => 1, // Default to Active on create
        ]);
    }
    public function update()
    {
        // dd($this->all());
        $this->tasks->update([
            'project_name' => $this->project_name,
            'area' => $this->area,
            'task_name' => $this->task_name,
            'due_date' => $this->due_date,
            'complete_date' => $this->complete_date ?: null, // Set to null if empty
            'status' => $this->status,
        ]);
        
    }

    public function updating()
    {
        return !empty($this->tasks);
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
        return view('livewire.task.task-form');
    }
}
