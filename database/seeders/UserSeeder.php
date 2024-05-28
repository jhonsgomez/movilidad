<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Si se desea agregar más usuarios, usar bcrypt en las contraseñas
        $array = array(
            array(
                'first_name' => 'Abigail',
                'second_name' => 'Otro nombre',
                'last_name' => 'Tello',
                'email' => 'sistemas@correo.uts.edu.co',
                'password' => Hash::make('SistemasUts2022*'),
                'rol_id' => '6'
            ),
        );

        DB::table('users')->insert($array);
    }
}
