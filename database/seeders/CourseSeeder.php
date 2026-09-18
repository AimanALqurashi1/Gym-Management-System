<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'name' => 'fitness',
            'level' => 'Beginner',
            'duration' => '3',
            'billing_cycle' => 'quarterly',
            'price' => '3000',
            'status' => '1',

            'description' => 'get your best version of energy and fitness',
            'category' => 'Physical',
            'added_by' => '1',
        ]);

        Course::create([
            'name' => 'Boxing',
            'level' => 'Beginner',
            'duration' => '3',
            'billing_cycle' => 'quarterly',
            'price' => '6000',
            'status' => '1',

            'description' => 'Fast hand , quick reaction, light feet',
            'category' => 'Physical',
            'added_by' => '1',
        ]);

        Course::create([
            'name' => 'Yuga',
            'level' => 'Beginner',
            'duration' => '3',
            'billing_cycle' => 'quarterly',
            'price' => '3000',
            'status' => '1',

            'description' => 'Ancient wisdom of cyclical growth',
            'category' => 'Physical',
            'added_by' => '1',
        ]);
    }
}
