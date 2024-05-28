<?php

namespace App\Exports;

use App\Models\InstEntInt;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class InstEntIntExport implements FromQuery, WithHeadings
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
        return InstEntInt::query()
            ->select(
                'inst_ent_ints.id',
                DB::raw('UPPER(inst_ent_ints.nombre) as nombre'),
                DB::raw('CONCAT(UCASE(LEFT(inst_ent_ints.pais, 1)), LCASE(SUBSTRING(inst_ent_ints.pais, 2))) as pais'),
                DB::raw('CONCAT(UCASE(LEFT(inst_ent_ints.ciudad, 1)), LCASE(SUBSTRING(inst_ent_ints.ciudad, 2))) as ciudad'),
                'inst_ent_ints.nit',
                DB::raw('UPPER(inst_ent_ints.representante) as representante'),
                'inst_ent_ints.telefono',
                DB::raw('LOWER(inst_ent_ints.email) as email')
            )->whereDate('inst_ent_ints.created_at', ">=", $this->iniDate)->whereDate('inst_ent_ints.created_at', "<=", $this->finalDate)
            ->where('inst_ent_ints.estado', 1);
    }

    public function headings(): array
    {
        return [
            'ID',
            'NOMBRE',
            'PAIS',
            'CIUDAD',
            'NIT O EQUIVALENTE',
            'REPRESENTANTE',
            'TELEFONO',
            'EMAIL'
        ];
    }
}
