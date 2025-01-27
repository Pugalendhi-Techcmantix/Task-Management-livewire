<?php

namespace App\Exports;

use App\Models\Tasks;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TaskExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    // Define status labels
    public $statusLabels = [
        1 => 'Pending',
        2 => 'Progress',
        3 => 'Hold',
        4 => 'Completed',
    ];

    // Define status text colors (use integer keys to match database values)
    public $statusTextColors = [
        1 => 'FFA500', // orange for Pending
        2 => '0000FF', // Blue for Progress
        3 => 'FF0000', // Red for Hold
        4 => '00FF00', // Green for Completed
    ];

    public function collection()
    {
        // Fetch all tasks with the related user data
        return Tasks::with(['employee', 'user'])->select('id', 'project_name', 'area', 'task_name', 'due_date', 'complete_date', 'status', 'employee_id', 'user_id', 'created_at')->get();
    }
    public function headings(): array
    {
        return ['S.No', 'Project', 'Area', 'Task', 'Due-Date', 'Completion-Date', 'Status', 'Employee', 'Assigned By', 'Assigned-Date']; // Custom headers
    }

    public function map($task): array
    {
        // Map status value to its corresponding label
        $statusLabel = $this->statusLabels[$task->status] ?? 'Unknown'; // Default to 'Unknown' if status is not found
        return [
            $task->id, // Increment serial number
            $task->project_name,
            $task->area,
            $task->task_name,
            $task->due_date,
            $task->complete_date,
            $statusLabel,
            $task->employee->name, // Employee's username
            $task->user->name, // User's username
            $task->created_at,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Apply style to the first row (headings) to set the background color to green
        $styles = [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'], // White text color
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'black'], // Green background color
                ],
            ],
        ];

        // Loop through each row and apply status-specific text colors to the status column
        $row = 2; // Start from the second row (first row is the header)
        foreach ($this->collection() as $task) {
            $statusColor = $this->statusTextColors[$task->status] ?? '000000'; // Default to black if status is not found
            $styles['G' . $row] = [
                'font' => [
                    'color' => ['rgb' => $statusColor], // Apply status-specific text color
                ],
            ];
            $row++;
        }
        return $styles;
    }
}
