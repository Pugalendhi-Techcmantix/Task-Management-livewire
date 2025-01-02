<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Insert sample data into the 'users' table
        DB::table('users')->insert([
            [
               'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('demo1234'), // Encrypt the password
                'age' => '22',
                'position' => 'Frontend',
                'salary' => 25000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status' => '1',
                'role_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Asim',
                'email' => 'asim@gmail.com',
                'password' => Hash::make('demo1234'), // Encrypt the password
                'age' => '22',
                'position' => 'Frontend',
                'salary' => 25000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status' => '1',
                'role_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kevin',
                'email' => 'kevin@gmail.com',
                'password' => Hash::make('demo1234'), // Encrypt the password
                'age' => '22',
                'position' => 'Frontend',
                'salary' => 25000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status' => '1',
                'role_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Viwin',
                'email' => 'viwin@gmail.com',
                'password' => Hash::make('demo1234'), // Encrypt the password
                'age' => '23',
                'position' => 'Tester',
                'salary' => 20000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status' => '1',
                'role_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Raja',
                'email' => 'raja@gmail.com',
                'password' => Hash::make('demo1234'), // Encrypt the password
                'age' => '23',
                'position' => 'Backend',
                'salary' => 20000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status' => '1',
                'role_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pugalendhi',
                'email' => 'pugalendhi@techcmantix.com',
                'password' => Hash::make('demo1234'), // Encrypt the password
                'age' => '23',
                'position' => 'Full-Stack Developer',
                'salary' => 25000,
                'joining_date' => '2024-10-14', // Correct date format: Y-m-d
                'status' => '1',
                'role_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
