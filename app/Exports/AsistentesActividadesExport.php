<?php

namespace App\Exports;

use App\Models\AsistentesActividades;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AsistentesActividadesExport implements FromCollection, WithHeadings
{
    protected $actividad_id;

    public function __construct($actividad_id)
    {
        $this->actividad_id = $actividad_id;
    }
    
    public function collection()
    {
        return DB::table('actividades_asistentes')
            ->join('actividades', 'actividades_asistentes.actividad_id', '=', 'actividades.id')
            ->join('programas_academicos', 'actividades_asistentes.programa_academico', '=', 'programas_academicos.id')
            ->select(
                'actividades_asistentes.documento',
                DB::RAW('UPPER(actividades_asistentes.nombre) AS nombre'),
                DB::RAW('CONCAT(UCASE(LEFT(programas_academicos.nombre, 1)), LCASE(SUBSTRING(programas_academicos.nombre, 2))) AS programa_academico'),
                'actividades_asistentes.periodo_academico',
                DB::RAW('LOWER(actividades_asistentes.correo_institucional) AS correo_institucional'),
                'actividades_asistentes.numero_telefono'
            )
            ->where('actividades_asistentes.actividad_id', '=', $this->actividad_id)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Documento',
            'Nombre',
            'Programa Académico',
            'Periodo Académico',
            'Correo Institucional',
            'Número de Teléfono'
        ];
    }
}
