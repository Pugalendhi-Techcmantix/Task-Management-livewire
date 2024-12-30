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
                'due_date' => '2024-12-25',
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
                'due_date' => '2024-12-26',
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
                'due_date' => '2024-12-27',
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
                'due_date' => '2024-12-28',
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
                'due_date' => '2024-12-29',
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
                'due_date' => '2024-12-29',
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
                'due_date' => '2024-12-29',
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
                'due_date' => '2024-12-29',
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
                'due_date' => '2024-12-29',
                'status' => '1',
                'employee_id' => '5',
                'user_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
