<?php

namespace Database\Seeders;

use App\Models\UserTypeModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creamos un array para que nos rellene por defecto los datos de entrada 
        $data = [
            ['name' => 'Administrador'],
            ['name' => 'Consultor']
        ];

        //Recorremos cada uno de estos campos
        foreach($data as $d){
            UserTypeModel::create($d);
        }

       
    }
}
