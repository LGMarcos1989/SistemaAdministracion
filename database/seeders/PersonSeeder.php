<?php

namespace Database\Seeders;

use App\Models\PersonModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'fullname' => 'Carlos',
                'lastname' => 'Garcia',
                'dni' => '1092010900',
                'city' => 'Madrid',
                'phone' => '0923921839128',
                'user_id' => 1,
            ],
            [
                'fullname' => 'Lorena',
                'lastname' => 'Garcia',
                'dni' => '109201035978',
                'city' => 'Valladolid',
                'phone' => '092392181092',
                'user_id' => 2,
            ],
        ];

        foreach ($data as $d) {
            PersonModel::create($d);
        }
    }
}
