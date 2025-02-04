<?php

namespace App\Livewire\Task;

use App\Exports\TaskExport;
use App\Imports\TaskImport;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class TaskList extends Component
{
    use Toast;
    use WithFileUploads;
    public $file; // For handling the uploaded file
    public $search = '', $task_id, $confirmDelete = false, $confirmOpen = false;
    public int $perPage = 10; // Number of items per page
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];
    protected $listeners = ['refresh-tasks-table' => '$refresh'];

    public $importErrors = []; // Store validation errors
    public $validData = []; // Store valid rows for import

    public $statusLabels = [
        1 => 'Pending',
        2 => 'Progress',
        3 => 'Hold',
        4 => 'Completed',
    ];

    public function openDeleteModal($task_id)
    {
        $this->confirmDelete = true;    // Trigger modal visibility
        $this->task_id = $task_id; // Assign the employee ID to delete
    }


    public function destroy()
    {
        Tasks::findOrfail($this->task_id)->delete();
        $this->confirmDelete = false;
        $this->dispatch('refresh-role-table');
    }

    public function deleteAllMessages()
    {
        Tasks::truncate(); // Deletes all records from the chats table
    }

    public function importOpen()
    {
        $this->confirmOpen = true;
        $this->importErrors = []; // Reset errors
        $this->validData = []; // Reset valid data
        $this->file = null; // Clear the file input field
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv', // Validate file format
        ]);

        $filePath = $this->file->getRealPath(); // Get file path
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray(); // Convert sheet to an array

        $this->importErrors = []; // Reset errors
        $this->validData = []; // Reset valid data

        foreach ($rows as $key => $row) {
            if ($key === 0) continue; // Skip header row

            $project = trim($row[1]);
            $area = trim($row[2]);
            $task = trim($row[3]);
            $due_date = trim($row[4]);
            $employeeName = trim($row[5]);

            // Validate Employee
            $employee = User::where('name', $employeeName)->first();
            if (!$employee) {
                // $this->importErrors[] = "Row " . ($key + 1) . ": Employee '$employeeName' not found.";
                $this->importErrors[] = "Row " . ($key + 1) . ", Column: Employee : {$employeeName} not found.";
                continue;
            }
            // Store valid data for import
            $this->validData[] = [
                'project_name' => $project,
                'area' => $area,
                'task_name' => $task,
                'employee_id' => $employee->id,
                'user_id' => Auth::id(),
            ];
        }

        if (!empty($this->importErrors)) {
            return; // Stop execution if errors exist
        }

        // Now, use Excel::import for batch inserting
        Excel::import(new TaskImport(), $this->file);


        $this->confirmOpen = false;

        $this->toast(
            type: 'successs',
            title: 'Done!',
            description: 'Succesfully Added!.',
            position: 'toast-top toast-end',
            icon: 'o-check-badge',
            css: 'alert-info',
            redirectTo: null
        );
    }



    public function export()
    {
        return Excel::download(new TaskExport(), 'tasks.xlsx');
    }
    public function render()
    {
        $headers = [
            ['key' => 'id', 'label' => 'S.No', 'sortable' => true,],
            ['key' => 'project_name', 'label' => 'Project Name', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'area', 'label' => 'Area', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'task_name', 'label' => 'Task Name', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'employee.name', 'label' => 'Employee', 'sortable' => false, 'class' => 'truncate'],
            ['key' => 'user.name', 'label' => 'Assigned By', 'sortable' => false, 'class' => 'truncate'],
            ['key' => 'due_date', 'label' => 'Due Date ', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'complete_date', 'label' => 'Complete Date ', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'status', 'label' => 'Status', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'created_at', 'label' => 'Created At', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'updated_at', 'label' => 'Updated At', 'sortable' => true, 'class' => 'truncate'],
            ['key' => 'actions', 'label' => 'Action', 'sortable' => false],
        ];

        // Query to fetch tasks with the search applied to multiple columns
        $tasks = Tasks::query()
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('project_name', 'like', '%' . $this->search . '%')
                    ->orWhere('area', 'like', '%' . $this->search . '%')
                    ->orWhere('task_name', 'like', '%' . $this->search . '%')
                    ->orWhere('due_date', 'like', '%' . $this->search . '%')
                    ->orWhere('complete_date', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%')
                    ->orWhereHas('employee', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
                // Check for status labels
                foreach ($this->statusLabels as $key => $label) {
                    if (stripos($label, $this->search) !== false) {
                        $query->orWhere('status', $key);
                    }
                }
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
        return view(
            'livewire.task.task-list',
            [
                'headers' => $headers,
                'tasks' => $tasks,
            ]
        );
    }
}
