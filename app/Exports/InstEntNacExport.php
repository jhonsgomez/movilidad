<?php

namespace App\Exports;

use App\Models\InstEntNac;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class InstEntNacExport implements FromQuery, WithHeadings
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
        return InstEntNac::query()
            ->select(
                'inst_ent_nacs.id',
                DB::raw('UPPER(inst_ent_nacs.nombre) as nombre'),
                DB::raw('CONCAT(UCASE(LEFT(inst_ent_nacs.ciudad, 1)), LCASE(SUBSTRING(inst_ent_nacs.ciudad, 2))) as ciudad'),
                'inst_ent_nacs.nit',
                DB::raw('UPPER(inst_ent_nacs.representante) as representante'),
                'inst_ent_nacs.telefono',
                DB::raw('LOWER(inst_ent_nacs.email) as email')
            )
            ->whereDate('inst_ent_nacs.created_at', '>=', $this->iniDate)
            ->whereDate('inst_ent_nacs.created_at', '<=', $this->finalDate)
            ->where('inst_ent_nacs.estado', 1);
    }

    public function headings(): array
    {
        return [
            'ID',
            'NOMBRE',
            'CIUDAD',
            'NIT',
            'REPRESENTANTE LEGAL',
            'TELEFONO',
            'EMAIL'
        ];
    }
}
