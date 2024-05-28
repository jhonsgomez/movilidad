<?php

namespace App\Exports;

use App\Models\ConvenioNac;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ConvenioNacExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function query()
    {
        return ConvenioNac::query()
                ->join('inst_ent_nacs', 'convenio_nacs.instEntNac_id', '=', 'inst_ent_nacs.id')
                ->select(
                    'convenio_nacs.id', // Columna 1: ID
                    'inst_ent_nacs.nombre AS institucion', // Columna 2: Nombre de la institución
                    'convenio_nacs.breve_objeto AS breve_objeto', // Columna 3: Breve Objeto
                    'convenio_nacs.resultados_concretos AS resultados_concretos', // Columna 4: Resultados Concretos
                    // Columna 5: Vigencia (años)
                    DB::raw("CONCAT(DATEDIFF(convenio_nacs.vigencia, convenio_nacs.fechaInicio) DIV 365, ' Años ', 
                            DATEDIFF(convenio_nacs.vigencia, convenio_nacs.fechaInicio) % 365 DIV 7, ' semanas ', 
                            DATEDIFF(convenio_nacs.vigencia, convenio_nacs.fechaInicio) % 7, ' días') AS vigencia"),
                    // Columna 6: Activo
                    DB::raw("IF(convenio_nacs.activo = 'Si', 'Activo', '') AS activo"),
                    // Columna 7: N° de usuarios/No Aplica
                    DB::raw("IF(convenio_nacs.n_usuarios = 0, 'No Aplica', convenio_nacs.n_usuarios) AS n_usuarios"),
                    // Columna 8: Nacional/Internacional
                    DB::raw("IF(convenio_nacs.es_nacional = 1, 'Nacional', 'Internacional') AS es_nacional")
                )
                ->whereDate('convenio_nacs.created_at', ">=", "0001-01-01")
                ->whereDate('convenio_nacs.created_at', "<=", "9999-12-31")
                ->where('convenio_nacs.estado', 1);
    }

    public function headings(): array
    {
        return [];
    }
}
