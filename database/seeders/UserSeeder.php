<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $data = [
            [
                'email' => 'admin@yopmail.com',
                'password' => Hash::make('admin2025'),
                'user_type_id' => 1
            ],
            [
                'email' => 'lorena@yopmail.com',
                 'password' => Hash::make('lorena2025'),
                'user_type_id' => 2
            ],
        ];

      
      User::upsert($data, ['email'], ['password', 'user_type_id']);
    }
}
