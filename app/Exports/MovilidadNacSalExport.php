<?php

namespace App\Exports;

use App\Models\MovilidadNacSal;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MovilidadNacSalExport implements FromQuery, WithHeadings
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
        return MovilidadNacSal::query()->join('inst_ent_nacs', 'movilidad_nac_sals.instEnt_id', '=', 'inst_ent_nacs.id')
            ->select(
                'movilidad_nac_sals.tipoPersona',
                'movilidad_nac_sals.colInd',
                'movilidad_nac_sals.fullname',
                'movilidad_nac_sals.cantidad',
                'movilidad_nac_sals.titulosOb',
                'inst_ent_nacs.nombre',
                'movilidad_nac_sals.activo',
                'movilidad_nac_sals.fecha',
                'movilidad_nac_sals.vigencia',
                'movilidad_nac_sals.sedeReg',
                'movilidad_nac_sals.objeto',
                'movilidad_nac_sals.resultado',
                'movilidad_nac_sals.created_at',
            )->whereDate('movilidad_nac_sals.created_at', ">=", $this->iniDate)->whereDate('movilidad_nac_sals.created_at', "<=", $this->finalDate)
            ->where('movilidad_nac_sals.estado', 1);
    }

    public function headings(): array
    {
        return [
            'Tipo de Persona',
            'Colectivo o individual ',
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
