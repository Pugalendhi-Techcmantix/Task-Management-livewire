<?php

namespace App\Imports;

use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate; // Import Excel Date utility

class TaskImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $Assigned = Auth::user()->id;
        // Iterate through each row of the collection
        foreach ($collection as  $key => $row) {
            // Skip the first row, which contains headers
            if ($key === 0) {
                continue;
            }
            // Access each column by its index, assuming:
            $Project = trim($row[1]);
            $Area = trim($row[2]);
            $Task = trim($row[3]);
            $Due_Date = trim($row[4]); // Date in format "27-01-2025"
            $Employee = trim($row[5]);

            // Find the Employee ID from the Users table
            $Employee = User::where('name', $Employee)->first();
            if (!$Employee) {
                Log::error("Employee not found in row {$key}: {$Employee}");
                continue; // Skip this row if employee not found
            }


            // Convert Excel serial date to a Carbon date object
            try {
                $Due_Date = Carbon::instance(ExcelDate::excelToDateTimeObject($Due_Date))->format('Y-m-d');
            } catch (\Exception $e) {
                // Log the error and skip this row
                Log::error("Invalid date format in row {$key}: {$Due_Date}");
                continue; // Skip this row
            }
            // Create and save the task record
            Tasks::create([
                'project_name' => $Project,
                'area' => $Area,
                'task_name' => $Task,
                'due_date' => $Due_Date,
                'employee_id' => $Employee->id,
                'user_id' => $Assigned,
            ]);
        }
    }
}
