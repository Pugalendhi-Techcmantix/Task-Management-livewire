<?php

namespace Database\Seeders;

use App\Models\Tasks;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Tasks::insert([
            [
                'project_name' => 'Task Management',
                'area' => 'frontend',
                'task_name' => 'create login page',
                'due_date' => '2025-01-01',
                'status' => '4',
                'employee_id' => '2',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_name' => 'Task Management',
                'area' => 'frontend',
                'task_name' => 'setup dashboard charts,cards',
                'due_date' => '2025-01-01',
                'status' => '1',
                'employee_id' => '2',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_name' => 'Task Management',
                'area' => 'frontend',
                'task_name' => 'create profile page',
                'due_date' => '2025-01-02',
                'status' => '3',
                'employee_id' => '2',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_name' => 'Task Management',
                'area' => 'frontend',
                'task_name' => 'create master setup layout',
                'due_date' => '2025-01-01',
                'status' => '2',
                'employee_id' => '2',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_name' => 'Task Management',
                'area' => 'frontend',
                'task_name' => 'create menu,header,footer,logout',
                'due_date' => '2025-01-02',
                'status' => '1',
                'employee_id' => '2',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_name' => 'Task Management',
                'area' => 'backend',
                'task_name' => 'login authentications',
                'due_date' => '2025-01-02',
                'status' => '4',
                'employee_id' => '5',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_name' => 'Task Management',
                'area' => 'backend',
                'task_name' => 'menus ,dashboard cards,counts',
                'due_date' => '2025-01-01',
                'status' => '2',
                'employee_id' => '5',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_name' => 'Task Management',
                'area' => 'backend',
                'task_name' => 'main modules',
                'due_date' => '2025-01-02',
                'status' => '3',
                'employee_id' => '5',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_name' => 'Task Management',
                'area' => 'backend',
                'task_name' => 'master modules',
                'due_date' => '2025-01-02',
                'status' => '1',
                'employee_id' => '5',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_name' => 'KMV',
                'area' => 'full-stack',
                'task_name' => 'create login,dashboard,profile pages',
                'due_date' => '2025-01-02',
                'status' => '2',
                'employee_id' => '6',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
