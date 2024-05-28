<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Agregar acá otros roles si es necesario
        $array = array(
            array('rol_codigo' => 'COORD', 'rol_name' => 'Coordinacion', 'estado' => 1),
            array('rol_codigo' => 'ORI', 'rol_name' => 'Oficina de Relaciones Interinstitucionales', 'estado' => 1),
            array('rol_codigo' => 'DIE', 'rol_name' => 'Dirección de Investigación y Extensión', 'estado' => 1),
            array('rol_codigo' => 'DEC', 'rol_name' => 'Decanatura', 'estado' => 1),
            array('rol_codigo' => 'OTRA', 'rol_name' => 'Otra dependencia', 'estado' => 1),
            array('rol_codigo' => 'SUPERADMIN', 'rol_name' => 'Super Administrador', 'estado' => 1),
        );

        DB::table('roles')->insert($array);
    }
}
