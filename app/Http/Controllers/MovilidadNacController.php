<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InstEntNac;
use App\Models\Movilidad;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MovilidadNacController extends Controller
{
    public function index()
    {
        $movilidades = DB::table('movilidad')
            ->join('inst_ent_nacs', 'movilidad.inst_ent_nacs', '=', 'inst_ent_nacs.id')
            ->select('movilidad.*', 'inst_ent_nacs.nombre AS entidad_origen',
                DB::raw("CONCAT(DATEDIFF(movilidad.fecha_final, movilidad.fecha_inicio), ' días') AS duracion")
            )
            ->where('movilidad.nac_ext', '=', 0)
            ->get();

        $movilidadesConActividades = [];
        
        foreach ($movilidades as $movilidad) {
            $actividades = DB::table('actividades')
                ->join('inst_ent_nacs', 'actividades.inst_ent_nacs', '=', 'inst_ent_nacs.id')
                ->select('actividades.*', 'inst_ent_nacs.nombre AS ies')
                ->where('actividades.movilidad', '=', $movilidad->id)
                ->get();
    
            $movilidadesConActividades[$movilidad->id] = [
                'movilidad' => $movilidad,
                'actividades' => $actividades
            ];
        }

        return view('movilidades.indexnac', compact('movilidadesConActividades'));
    }

    public function create()
    {
        $instituciones = InstEntNac::where('estado', 1)->get();
        return view('movilidades.createnac', compact('instituciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'documento' => 'required',
            'nombre' => 'required',
            'est_pro' => 'required',
            'inst_ent_nacs' => 'required',
            'pais' => 'required',
            'objeto' => 'required',
            'resultados' => 'required',
            'pres_virt' => 'required',
            'ent_sal' => 'required',
            'nac_ext' => 'required',
            'fecha_inicio' => 'required',
            'fecha_final' => 'required',
            'doc_soporte' => 'required'
        ]);

        $files = [];

        if ($request->hasFile('doc_soporte')) {
            foreach ($request->file('doc_soporte') as $file) {
                $name = time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('files/movilidadNac'), $name);
                $files[] = $name;
            }
        }

        $movilidad = new Movilidad();

        $movilidad->documento = $request->post('documento');
        $movilidad->nombre = $request->post('nombre');
        $movilidad->est_pro = $request->post('est_pro');
        $movilidad->inst_ent_nacs = $request->post('inst_ent_nacs');
        $movilidad->pais = $request->post('pais');
        $movilidad->objeto = $request->post('objeto');
        $movilidad->resultados = $request->post('resultados');
        $movilidad->pres_virt = $request->post('pres_virt');
        $movilidad->ent_sal = $request->post('ent_sal');
        $movilidad->nac_ext = $request->post('nac_ext');
        $movilidad->fecha_inicio = $request->post('fecha_inicio');
        $movilidad->fecha_final = $request->post('fecha_final');
        $movilidad->doc_soporte = implode(',', $files);

        $movilidad->save();

        return redirect()->route('movilidades_nac.index')
            ->with('success', 'Movilidad creada correctamente!');
    }

    public function download($file)
    {
        return response()->download(public_path('files/movilidadNac/' . $file));
    }

    public function edit($mov_id)
    {
        $instituciones = InstEntNac::where('estado', 1)->get();
        $movilidad = Movilidad::findOrFail($mov_id);

        return view('movilidades.editnac', compact(['instituciones', 'movilidad']));
    }

    public function update(Request $request, $mov_id)
    {
        $request->validate([
            'documento' => 'required',
            'nombre' => 'required',
            'est_pro' => 'required',
            'inst_ent_nacs' => 'required',
            'pais' => 'required',
            'objeto' => 'required',
            'resultados' => 'required',
            'pres_virt' => 'required',
            'ent_sal' => 'required',
            'nac_ext' => 'required',
            'fecha_inicio' => 'required',
            'fecha_final' => 'required'
        ]);

        $movilidad = Movilidad::findOrFail($mov_id);

        $movilidad->documento = $request->documento;
        $movilidad->nombre = $request->nombre;
        $movilidad->est_pro = $request->est_pro;
        $movilidad->inst_ent_nacs = $request->inst_ent_nacs;
        $movilidad->pais = $request->pais;
        $movilidad->objeto = $request->objeto;
        $movilidad->resultados = $request->resultados;
        $movilidad->pres_virt = $request->pres_virt;
        $movilidad->ent_sal = $request->ent_sal;
        $movilidad->nac_ext = $request->nac_ext;
        $movilidad->fecha_inicio = $request->fecha_inicio;
        $movilidad->fecha_final = $request->fecha_final;
    
        $movilidad->save();

        return redirect()->route('movilidades_nac.index')
            ->with('success', 'Movilidad editada correctamente!');
    }

    public function destroy($mov_id)
    {
        $movilidad = Movilidad::findOrFail($mov_id);
        $movilidad->delete();
        
        return redirect()->route('movilidades_nac.index')
            ->with('success', 'Movilidad eliminada correctamente!');
    }

    public function exporting(Request $request)
    {  
        $from = $request->input('export_fecha_inicial');
        $to = $request->input('export_fecha_final');

        if ($from == Null && $to == Null) {
            $from = "0001-01-01";
            $to = "9999-12-31";
        } elseif ($from != "" && $to == "") {
            $to = "9999-12-31";
        }

        $archivoExcel = public_path('files\excel\FormatoMovilidades.xlsx');
        $spreadsheet = IOFactory::load($archivoExcel);

        $sheet = $spreadsheet->getActiveSheet();

        $datos = DB::table('movilidad')
                ->select(
                    'movilidad.id',
                    'movilidad.documento',
                    DB::raw('UPPER(movilidad.nombre) AS nombre'),
                    DB::raw('CASE WHEN movilidad.est_pro = 0 THEN "Estudiante" ELSE "Profesor" END AS tipo_persona'),
                    DB::raw('UPPER(CASE 
                                WHEN movilidad.nac_ext = 0 THEN inst_ent_nacs.nombre 
                                ELSE inst_ent_ints.nombre 
                            END) AS entidad_origen'),
                    DB::raw('CONCAT(UCASE(LEFT(movilidad.pais, 1)), LCASE(SUBSTRING(movilidad.pais, 2))) AS pais'),
                    DB::raw('CONCAT(UCASE(LEFT(movilidad.objeto, 1)), LCASE(SUBSTRING(movilidad.objeto, 2))) AS objeto'),
                    DB::raw('CONCAT(UCASE(LEFT(movilidad.resultados, 1)), LCASE(SUBSTRING(movilidad.resultados, 2))) AS resultados'),
                    DB::raw('CASE WHEN movilidad.pres_virt = 0 THEN "Presencial" ELSE "Virtual" END AS tipo'),
                    DB::raw('CASE 
                                WHEN movilidad.ent_sal = 0 AND movilidad.nac_ext = 0 THEN 1 
                                ELSE "" 
                            END AS ent_nac'),
                    DB::raw('CASE 
                                WHEN movilidad.ent_sal = 0 AND movilidad.nac_ext = 1 THEN 1 
                                ELSE "" 
                            END AS ent_int'),
                    DB::raw('CASE 
                                WHEN movilidad.ent_sal = 1 AND movilidad.nac_ext = 0 THEN 1 
                                ELSE "" 
                            END AS sal_nac'),
                    DB::raw('CASE 
                                WHEN movilidad.ent_sal = 1 AND movilidad.nac_ext = 1 THEN 1 
                                ELSE "" 
                            END AS sal_int'),
                    DB::raw('DATE_FORMAT(movilidad.fecha_inicio, "%d/%m/%Y") AS fecha_inicio'),
                    DB::raw('DATE_FORMAT(movilidad.fecha_final, "%d/%m/%Y") AS fecha_final'),
                    DB::raw('CONCAT(DATEDIFF(movilidad.fecha_final, movilidad.fecha_inicio), " día/s") AS duracion')
                )
                ->whereDate('movilidad.fecha_inicio', ">=", $from)
                ->whereDate('movilidad.fecha_inicio', "<=", $to)
                ->leftJoin('inst_ent_nacs', 'movilidad.inst_ent_nacs', '=', 'inst_ent_nacs.id')
                ->leftJoin('inst_ent_ints', 'movilidad.inst_ent_ints', '=', 'inst_ent_ints.id')
                ->get();

        $lastRow = $sheet->getHighestRow();

        $newRowIndex = $lastRow + 1;

        foreach ($datos as $dato) {
            $sheet->setCellValue('A' . $newRowIndex, $dato->id);
            $sheet->setCellValue('B' . $newRowIndex, $dato->documento);
            $sheet->setCellValue('C' . $newRowIndex, $dato->nombre);
            $sheet->setCellValue('D' . $newRowIndex, $dato->tipo_persona);
            $sheet->setCellValue('E' . $newRowIndex, $dato->entidad_origen);
            $sheet->setCellValue('F' . $newRowIndex, $dato->pais);
            $sheet->setCellValue('G' . $newRowIndex, $dato->objeto);
            $sheet->setCellValue('H' . $newRowIndex, $dato->resultados);
            $sheet->setCellValue('I' . $newRowIndex, $dato->tipo);
            $sheet->setCellValue('J' . $newRowIndex, $dato->ent_nac);
            $sheet->setCellValue('K' . $newRowIndex, $dato->ent_int);
            $sheet->setCellValue('L' . $newRowIndex, $dato->sal_nac);
            $sheet->setCellValue('M' . $newRowIndex, $dato->sal_int);
            $sheet->setCellValue('N' . $newRowIndex, $dato->fecha_inicio);
            $sheet->setCellValue('O' . $newRowIndex, $dato->fecha_final);
            $sheet->setCellValue('P' . $newRowIndex, $dato->duracion);

            $sheet->getStyle('A' . $newRowIndex . ':P' . $newRowIndex)->getAlignment()->setWrapText(true);
            $sheet->getStyle('A' . $newRowIndex . ':P' . $newRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $newRowIndex . ':P' . $newRowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyle('A' . $newRowIndex . ':P' . $newRowIndex)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);
            
            $newRowIndex++;
        }

        $response = new StreamedResponse(function () use ($spreadsheet) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="UTS - Reporte de movilidades.xlsx"');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        return $response;
    }
}
