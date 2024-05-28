<?php

namespace App\Exports;

use App\Models\MovilidadIntEnt;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MovilidadIntEntExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function forDate(string $iniDate, string $finalDate)
    {
        $this->iniDate = $iniDate;
        $this->finalDate = $finalDate;

        return $this;
    }

    public function query()
    {
        return MovilidadIntEnt::query()->join('institucion_entidad_ints', 'movilidad_int_ents.instEnt_id', '=', 'institucion_entidad_ints.id')
            ->select(
                'movilidad_int_ents.tipoPersona',
                'movilidad_int_ents.colInd',
                'movilidad_int_ents.fullname',
                'movilidad_int_ents.cantidad',
                'movilidad_int_ents.titulosOb',
                'institucion_entidad_ints.nombre',
                'movilidad_int_ents.activo',
                'movilidad_int_ents.fecha',
                'movilidad_int_ents.vigencia',
                'movilidad_int_ents.sedeReg',
                'movilidad_int_ents.objeto',
                'movilidad_int_ents.resultado',
                'movilidad_int_ents.created_at',
            )->whereDate('movilidad_int_ents.created_at', ">=", $this->iniDate)->whereDate('movilidad_int_ents.created_at', "<=", $this->finalDate)
            ->where('movilidad_int_ents.estado', 1);
    }

    public function headings(): array
    {
        return [
            'Tipo de Persona',
            'Colectivo o individual',
            'Nombre Completo',
            'Cantidad de Movilidades',
            'Titulo(s)',
            'Institución/Entidad',
            'Activo en la Institución/Entidad',
            'Fecha',
            'Vigencia',
            'Sede o Regional',
            'Objeto',
            'Resultado',
            'Created at',
        ];
    }
}
