<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class memberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::create([
            'name' => 'member1',
            'email' => 'member1@example.com',
            'gender' => 'male',
            'phone' => '+54656735',
            'card_number' => '86786875',
            'address' => 'member1 Street 123',
            'status' => '1',

            'nationality' => 'yemen',
            'height' => '171',
            'weight' => '66',
            'code' => '7586924357',
            'added_by' => '1',
        ]);

        Member::create([
            'name' => 'member2',
            'email' => 'member2@example.com',
            'gender' => 'male',
            'phone' => '+678453453',
            'card_number' => '465435324',
            'address' => 'member2 Street 123',
            'status' => '1',

            'nationality' => 'yemen',
            'height' => '194',
            'weight' => '87',
            'code' => '53126457424',
            'added_by' => '1',
        ]);

        Member::create([
            'name' => 'member3',
            'email' => 'member3@example.com',
            'gender' => 'female',
            'phone' => '+5462335387',
            'card_number' => '4567542545',
            'address' => 'member3 Street 123',
            'status' => '1',

            'nationality' => 'yemen',
            'height' => '174',
            'weight' => '67',
            'code' => '57546354547',
            'added_by' => '1',
        ]);
    }
}
