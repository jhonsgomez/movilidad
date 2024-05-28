<?php

namespace App\Exports;

use App\Models\MovilidadNacEnt;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MovilidadNacEntExport implements FromQuery, WithHeadings
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
        return MovilidadNacEnt::query()->join('inst_ent_nacs', 'movilidad_nac_ents.instEnt_id', '=', 'inst_ent_nacs.id')
            ->select(
                'movilidad_nac_ents.tipoPersona',
                'movilidad_nac_ents.colInd',
                'movilidad_nac_ents.fullname',
                'movilidad_nac_ents.cantidad',
                'movilidad_nac_ents.titulosOb',
                'inst_ent_nacs.nombre',
                'movilidad_nac_ents.activo',
                'movilidad_nac_ents.fecha',
                'movilidad_nac_ents.vigencia',
                'movilidad_nac_ents.sedeReg',
                'movilidad_nac_ents.objeto',
                'movilidad_nac_ents.resultado',
                'movilidad_nac_ents.created_at',
            )->whereDate('movilidad_nac_ents.created_at', ">=", $this->iniDate)->whereDate('movilidad_nac_ents.created_at', "<=", $this->finalDate)
            ->where('movilidad_nac_ents.estado', 1);
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
