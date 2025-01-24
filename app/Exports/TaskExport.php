<?php

namespace App\Exports;

use App\Models\Tasks;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TaskExport implements FromCollection, WithHeadings, WithMapping,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        // Fetch all users from the database and return them as a collection
        return Tasks::select('project_name', 'area','task_name','due_date','complete_date','status','employee_id','user_id','created_at')->get();
    }
    public function headings(): array
    {
        return ['S.No', 'project_name', 'area','task_name','due_date','complete_date','status','employee_id','user_id','created_at']; // Custom headers
    }

    public function map($task): array
    {
        // Map each user's data and add a serial number (S.No)
        static $serial = 1; // Keeps track of serial number
        return [
            $serial++, // Increment serial number
            $task->project_name,
            $task->area,
            $task->task_name,
            $task->due_date,
            $task->complete_date,
            $task->status,
            $task->employee_id,
            $task->user_id,
            $task->created_at,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Apply style to the first row (headings) to set the background color to green
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'], // White text color
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4CAF50'], // Green background color
                ],
            ],
        ];
    }
}
