<?php

namespace App\Exports;

use App\Models\ConvenioInt;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConvenioIntExport implements FromQuery, WithHeadings
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
        return ConvenioInt::query()
            ->select(
                'convenio_ints.codigo',
                'convenio_ints.añoVin',
                'convenio_ints.tipo',
                'convenio_ints.int_ent',
                'convenio_ints.vigencia',
                'convenio_ints.programa',
                'convenio_ints.objeto',
                'convenio_ints.alcance',
                'convenio_ints.activo',
                'convenio_ints.fechaInicio',
                'convenio_ints.vig_pro',
                'convenio_ints.docSoporte',
                'convenio_ints.created_at',
            )->whereDate('convenio_ints.created_at', ">=", $this->iniDate)->whereDate('convenio_ints.created_at', "<=", $this->finalDate)
            ->where('convenio_ints.estado', 1);
    }

    public function headings(): array
    {
        return [
            'Código',
            'Año de Vinculación',
            'Tipo de Convenio',
            'Institución/Entidad',
            'Vigencia',
            'Programa(s)',
            'Objeto',
            'Alcance',
            'Activo',
            'Fecha de Inicio',
            'Vigencia de la Prorroga',
            'Documentación Soporte',
            'Created at',
        ];
    }
}
