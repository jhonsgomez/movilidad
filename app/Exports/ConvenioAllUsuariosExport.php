<?php

namespace App\Exports;

use App\Models\ConvenioUsuarios;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ConvenioAllUsuariosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $firstQuery = DB::table('convenio_usuarios')
            ->join('convenio_nacs', 'convenio_usuarios.convenio_id', '=', 'convenio_nacs.id')
            ->join('inst_ent_nacs', 'convenio_nacs.instEntNac_id', '=', 'inst_ent_nacs.id')
            ->join('programas_academicos', 'convenio_usuarios.programa_academico', '=', 'programas_academicos.id')
            ->where('convenio_usuarios.nac_int', '=', 0)
            ->select(
                'convenio_usuarios.documento',
                DB::raw('UPPER(convenio_usuarios.nombre) AS nombre'),
                DB::raw('CONCAT(UCASE(LEFT(programas_academicos.nombre, 1)), LCASE(SUBSTRING(programas_academicos.nombre, 2))) AS programa_academico'),
                'convenio_usuarios.periodo_academico',
                DB::raw('LOWER(convenio_usuarios.correo_institucional) AS correo_institucional'),
                'convenio_usuarios.numero_telefono',
                'convenio_usuarios.fecha_inicio',
                'convenio_usuarios.fecha_terminacion',
                'convenio_usuarios.duracion',
                DB::raw('UPPER(convenio_usuarios.supervisor) AS supervisor'),
                DB::raw('CONCAT(UCASE(LEFT(convenio_nacs.tipo, 1)), LCASE(SUBSTRING(convenio_nacs.tipo, 2))) AS tipo'),
                DB::raw('UPPER(inst_ent_nacs.nombre) AS convenio')
            )
            ->get();

        $secondQuery = DB::table('convenio_usuarios')
            ->join('convenio_ints', 'convenio_usuarios.convenio_id', '=', 'convenio_ints.id')
            ->join('inst_ent_ints', 'convenio_ints.instEntInt_id', '=', 'inst_ent_ints.id')
            ->join('programas_academicos', 'convenio_usuarios.programa_academico', '=', 'programas_academicos.id')
            ->where('convenio_usuarios.nac_int', '=', 1)
            ->select(
                'convenio_usuarios.documento',
                DB::raw('UPPER(convenio_usuarios.nombre) AS nombre'),
                DB::raw('CONCAT(UCASE(LEFT(programas_academicos.nombre, 1)), LCASE(SUBSTRING(programas_academicos.nombre, 2))) AS programa_academico'),
                'convenio_usuarios.periodo_academico',
                DB::raw('LOWER(convenio_usuarios.correo_institucional) AS correo_institucional'),
                'convenio_usuarios.numero_telefono',
                'convenio_usuarios.fecha_inicio',
                'convenio_usuarios.fecha_terminacion',
                'convenio_usuarios.duracion',
                DB::raw('UPPER(convenio_usuarios.supervisor) AS supervisor'),
                DB::raw('CONCAT(UCASE(LEFT(convenio_ints.tipo, 1)), LCASE(SUBSTRING(convenio_ints.tipo, 2))) AS tipo'),
                DB::raw('UPPER(inst_ent_ints.nombre) AS convenio')
            )
            ->get();

        $combined = $firstQuery->merge($secondQuery);

        return $combined;
    }

    public function headings(): array
    {
        return [
            'Documento',
            'Nombre',
            'Programa Académico',
            'Periodo Académico',
            'Correo Institucional',
            'Número de Teléfono',
            'Fecha de Inicio',
            'Fecha de Terminación',
            'Duración',
            'Supervisor',
            'Tipo de convenio',
            'Convenio'
        ];
    }
}
