<?php

namespace App\Exports;

use App\Models\MovilidadIntSal;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MovilidadIntSalExport implements FromQuery, WithHeadings
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
        return MovilidadIntSal::query()->join('institucion_entidad_ints', 'movilidad_int_sals.instEnt_id', '=', 'institucion_entidad_ints.id')
            ->select(
                'movilidad_int_sals.tipoPersona',
                'movilidad_int_sals.colInd',
                'movilidad_int_sals.fullname',
                'movilidad_int_sals.cantidad',
                'movilidad_int_sals.titulosOb',
                'institucion_entidad_ints.nombre',
                'movilidad_int_sals.activo',
                'movilidad_int_sals.fecha',
                'movilidad_int_sals.vigencia',
                'movilidad_int_sals.sedeReg',
                'movilidad_int_sals.objeto',
                'movilidad_int_sals.resultado',
                'movilidad_int_sals.created_at',
            )->whereDate('movilidad_int_sals.created_at', ">=", $this->iniDate)->whereDate('movilidad_int_sals.created_at', "<=", $this->finalDate)
            ->where('movilidad_int_sals.estado', 1);
    }

    public function headings(): array
    {
        return [
            'Tipo de Persona',
            'Colaborativa o Intidivial',
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
