<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::insert([
            [
                'name' => 'Pugal Gamer',
                'email' => 'pugal@example.com',
                'age' => '23',
                'position' => 'Software Developer',
                'salary' => 35000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status'=>'1',
                'role'=>'1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Asim',
                'email' => 'asim@example.com',
                'age' => '22',
                'position' => 'Frontend',
                'salary' => 25000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status'=>'1',
                'role'=>'2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kevin',
                'email' => 'kevin@example.com',
                'age' => '22',
                'position' => 'Frontend',
                'salary' => 25000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status'=>'1',
                'role'=>'2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Viwin',
                'email' => 'viwin@example.com',
                'age' => '23',
                'position' => 'Tester',
                'salary' => 20000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status'=>'2',
                'role'=>'2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Raja',
                'email' => 'raja@example.com',
                'age' => '23',
                'position' => 'Backend',
                'salary' => 20000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status'=>'2',
                'role'=>'2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
