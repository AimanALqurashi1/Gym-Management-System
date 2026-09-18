<?php

namespace Database\Seeders;

use App\Models\Trainer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trainer::create([
            'name' => 'Trainer1',
            'email' => 'Trainer1@example.com',
            'gender' => 'male',
            'phone' => '+1234567890',
            'card_number' => '19900101',
            'address' => 'Trainer1 Street 123',
            'status' => '1',

            'nationality' => 'yemen',
            'height' => '175',
            'weight' => '76',
            'code' => '22753866741',
            'added_by' => '1',
        ]);

        Trainer::create([
            'name' => 'Trainer2',
            'email' => 'Trainer2@example.com',
            'gender' => 'male',
            'phone' => '+5674564556',
            'card_number' => '456524524',
            'address' => 'Trainer2 Street 123',
            'status' => '1',

            'nationality' => 'yemen',
            'height' => '185',
            'weight' => '86',
            'code' => '78456197354',
            'added_by' => '1',
        ]);

        Trainer::create([
            'name' => 'Trainer3',
            'email' => 'Trainer3@example.com',
            'gender' => 'female',
            'phone' => '+8675645245',
            'card_number' => '54656876',
            'address' => 'Trainer3 Street 123',
            'status' => '1',

            'nationality' => 'yemen',
            'height' => '165',
            'weight' => '56',
            'code' => '33256148795',
            'added_by' => '1',
        ]);
    }
}
