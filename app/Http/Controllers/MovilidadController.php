<?php

namespace App\Http\Controllers;

use App\Models\Movilidad;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MovilidadController extends Controller
{

    public function nac_ext()
    {
        $nivel = session('nac_ext');
        if ($nivel == 'nacional')
            return 0;
        else if ($nivel == 'internacional')
            return 1;
        return null;
    }

    public function list()
    {
        $nivel = self::nac_ext();
        $movilidades = null;

        try {
            if ($nivel == 0) {
                $movilidades = DB::table('movilidades')
                    ->leftJoin('convenio_nacs', 'movilidades.convenio_id', '=', 'convenio_nacs.id')
                    ->leftJoin('inst_ent_nacs', 'convenio_nacs.instEntNac_id', '=', 'inst_ent_nacs.id')
                    ->select('movilidades.*', 'inst_ent_nacs.nombre AS institucion')
                    ->where('movilidades.nac_ext', '=', 0)
                    ->get();
            } else {
                $movilidades = DB::table('movilidades')
                    ->leftJoin('convenio_ints', 'movilidades.convenio_id', '=', 'convenio_ints.id')
                    ->leftJoin('inst_ent_ints', 'convenio_ints.instEntInt_id', '=', 'inst_ent_ints.id')
                    ->select('movilidades.*', 'inst_ent_ints.nombre AS institucion')
                    ->where('movilidades.nac_ext', '=', 1)
                    ->get();
            }

            return view('movilidades.index', compact(['movilidades', 'nivel']));
        } catch (Exception $e) {
            return redirect('/activities/');
        }
    }

    public function create()
    {
        $nivel = self::nac_ext();
        $convenios = null;

        try {
            if ($nivel == 0)
                $convenios = DB::table('convenio_nacs')
                    ->join('inst_ent_nacs', 'convenio_nacs.instEntNac_id', '=', 'inst_ent_nacs.id')
                    ->select('convenio_nacs.*', 'inst_ent_nacs.nombre AS institucion')
                    ->get();
            else
                $convenios = DB::table('convenio_ints')
                    ->join('inst_ent_ints', 'convenio_ints.instEntInt_id', '=', 'inst_ent_ints.id')
                    ->select('convenio_ints.*', 'inst_ent_ints.nombre AS institucion')
                    ->get();

            return view('movilidades.create', compact(['convenios', 'nivel']));
        } catch (Exception $e) {
            return redirect('/activities/');
        }
    }

    public function save(Request $request)
    {
        $nivel = self::nac_ext();

        $request->validate([
            'nac_ext' => 'required',
            'ent_sal' => 'required',
            'documento' => 'required',
            'nombre' => 'required',
            'tipo_persona' => 'required',
            'pais' => 'required',
            'actividad' => 'required',
            'pres_virt' => 'required',
            'descripcion' => 'required',
            'entidad' => 'required',
            'objeto' => 'required',
            'resultados' => 'required',
            'fecha_inicio' => 'required',
            'fecha_final' => 'required'
        ]);

        $files = [];

        try {
            if ($request->hasFile('doc_soporte')) {
                foreach ($request->file('doc_soporte') as $file) {
                    $name = time() . "_" . $file->getClientOriginalName();
                    if ($nivel == 0)
                        $file->move(public_path('files/movilidadNac'), $name);
                    else
                        $file->move(public_path('files/movilidadInt'), $name);
                    $files[] = $name;
                }
            }

            $movilidad = new Movilidad();

            $movilidad->nac_ext = $request->post('nac_ext');
            $movilidad->convenio_id = $request->post('convenio_id');
            $movilidad->ent_sal = $request->post('ent_sal');
            $movilidad->documento = $request->post('documento');
            $movilidad->nombre = $request->post('nombre');
            $movilidad->tipo_persona = $request->post('tipo_persona');
            $movilidad->pais = $request->post('pais');
            $movilidad->actividad = $request->post('actividad');
            $movilidad->pres_virt = $request->post('pres_virt');
            $movilidad->descripcion = $request->post('descripcion');
            $movilidad->entidad = $request->post('entidad');
            $movilidad->objeto = $request->post('objeto');
            $movilidad->resultados = $request->post('resultados');
            $movilidad->responsable = $request->post('responsable');
            $movilidad->fecha_inicio = $request->post('fecha_inicio');
            $movilidad->fecha_final = $request->post('fecha_final');
            $movilidad->doc_soporte = implode(',', $files);

            $movilidad->save();

            return redirect()->route('movilidades.list')
                ->with('success', 'Movilidad creada correctamente!');
        } catch (Exception $e) {
            return redirect('/activities/');
        }
    }

    public function edit(int $movilidad_id)
    {
        $nivel = self::nac_ext();
        $movilidad = Movilidad::findOrFail($movilidad_id);
        $convenios = null;

        try {
            if ($nivel == 0)
                $convenios = DB::table('convenio_nacs')
                    ->join('inst_ent_nacs', 'convenio_nacs.instEntNac_id', '=', 'inst_ent_nacs.id')
                    ->select('convenio_nacs.*', 'inst_ent_nacs.nombre AS institucion')
                    ->get();
            else
                $convenios = DB::table('convenio_ints')
                    ->join('inst_ent_ints', 'convenio_ints.instEntInt_id', '=', 'inst_ent_ints.id')
                    ->select('convenio_ints.*', 'inst_ent_ints.nombre AS institucion')
                    ->get();

            return view('movilidades.edit', compact(['movilidad', 'convenios', 'nivel']));
        } catch (Exception $e) {
            return redirect('/activities/');
        }
    }

    public function update(Request $request, int $movilidad_id)
    {
        $request->validate([
            'nac_ext' => 'required',
            'ent_sal' => 'required',
            'documento' => 'required',
            'nombre' => 'required',
            'tipo_persona' => 'required',
            'pais' => 'required',
            'actividad' => 'required',
            'pres_virt' => 'required',
            'descripcion' => 'required',
            'entidad' => 'required',
            'objeto' => 'required',
            'resultados' => 'required',
            'fecha_inicio' => 'required',
            'fecha_final' => 'required'
        ]);

        try {
            $movilidad = Movilidad::findOrFail($movilidad_id);

            $movilidad->nac_ext = $request->post('nac_ext');
            $movilidad->convenio_id = $request->post('convenio_id');
            $movilidad->ent_sal = $request->post('ent_sal');
            $movilidad->documento = $request->post('documento');
            $movilidad->nombre = $request->post('nombre');
            $movilidad->tipo_persona = $request->post('tipo_persona');
            $movilidad->pais = $request->post('pais');
            $movilidad->actividad = $request->post('actividad');
            $movilidad->pres_virt = $request->post('pres_virt');
            $movilidad->descripcion = $request->post('descripcion');
            $movilidad->entidad = $request->post('entidad');
            $movilidad->objeto = $request->post('objeto');
            $movilidad->resultados = $request->post('resultados');
            $movilidad->responsable = $request->post('responsable');
            $movilidad->fecha_inicio = $request->post('fecha_inicio');
            $movilidad->fecha_final = $request->post('fecha_final');

            $movilidad->save();

            return redirect()->route('movilidades.list')
                ->with('success', 'Movilidad editada correctamente!');
        } catch (Exception $e) {
            return redirect()->route('movilidades.list');
        }
    }

    public function delete(int $movilidad_id)
    {
        try {
            Movilidad::findOrFail($movilidad_id)->delete();
            return redirect()->route('movilidades.list')
                ->with('success', 'Movilidad eliminada correctamente!');
        } catch (Exception $e) {
            return redirect()->route('movilidades.list');
        }
    }

    public function download(string $file)
    {
        $nivel = self::nac_ext();

        try {
            if ($nivel == 0)
                return response()->download(public_path('files/movilidadNac/' . $file));
            else
                return response()->download(public_path('files/movilidadInt/' . $file));

        } catch (Exception $e) {
            return redirect('/activities/');
        }
    }

    public function export(Request $request)
    {
        $from = $request->input('export_fecha_inicial');
        $to = $request->input('export_fecha_final');

        if ($from == Null && $to == Null) {
            $from = "0001-01-01";
            $to = "9999-12-31";
        } elseif ($from != "" && $to == "") {
            $to = "9999-12-31";
        }

        $archivoExcel = public_path('files/excel/FormatoMovilidades.xlsx');
        $spreadsheet = IOFactory::load($archivoExcel);

        $sheet = $spreadsheet->getActiveSheet();

        $datos = DB::table('movilidades')
            ->select(
                'movilidades.id',
                'movilidades.documento',
                DB::raw('UPPER(movilidades.nombre) AS nombre'),
                'movilidades.tipo_persona',
                DB::raw('UPPER(movilidades.entidad) AS entidad'),
                DB::raw('CONCAT(UCASE(LEFT(movilidades.pais, 1)), LCASE(SUBSTRING(movilidades.pais, 2))) AS pais'),
                DB::raw('CONCAT(UCASE(LEFT(movilidades.objeto, 1)), LCASE(SUBSTRING(movilidades.objeto, 2))) AS objeto'),
                DB::raw('CONCAT(UCASE(LEFT(movilidades.resultados, 1)), LCASE(SUBSTRING(movilidades.resultados, 2))) AS resultados'),
                'movilidades.actividad',
                DB::raw('CASE WHEN movilidades.pres_virt = 0 THEN "Presencial" ELSE "Virtual" END AS tipo'),
                DB::raw('CASE WHEN movilidades.ent_sal = 0 AND movilidades.nac_ext = 0 THEN 1 ELSE "" END AS ent_nac'),
                DB::raw('CASE WHEN movilidades.ent_sal = 0 AND movilidades.nac_ext = 1 THEN 1 ELSE "" END AS ent_int'),
                DB::raw('CASE WHEN movilidades.ent_sal = 1 AND movilidades.nac_ext = 0 THEN 1 ELSE "" END AS sal_nac'),
                DB::raw('CASE WHEN movilidades.ent_sal = 1 AND movilidades.nac_ext = 1 THEN 1 ELSE "" END AS sal_int'),
                DB::raw('DATE_FORMAT(movilidades.fecha_inicio, "%d/%m/%Y") AS fecha_inicio'),
                DB::raw('DATE_FORMAT(movilidades.fecha_final, "%d/%m/%Y") AS fecha_final'),
                DB::raw('IF(movilidades.fecha_inicio = movilidades.fecha_final, "1 día/s", CONCAT(DATEDIFF(movilidades.fecha_final, movilidades.fecha_inicio), " día/s")) AS duracion')
            )
            ->whereDate('movilidades.fecha_inicio', '>=', $from)
            ->whereDate('movilidades.fecha_inicio', '<=', $to)
            ->get();

        $lastRow = $sheet->getHighestRow();

        $newRowIndex = $lastRow + 1;

        foreach ($datos as $dato) {
            $sheet->setCellValue('A' . $newRowIndex, $dato->id);
            $sheet->setCellValue('B' . $newRowIndex, $dato->documento);
            $sheet->setCellValue('C' . $newRowIndex, $dato->nombre);
            $sheet->setCellValue('D' . $newRowIndex, $dato->tipo_persona);
            $sheet->setCellValue('E' . $newRowIndex, $dato->entidad);
            $sheet->setCellValue('F' . $newRowIndex, $dato->pais);
            $sheet->setCellValue('G' . $newRowIndex, $dato->objeto);
            $sheet->setCellValue('H' . $newRowIndex, $dato->resultados);
            $sheet->setCellValue('I' . $newRowIndex, $dato->actividad);
            $sheet->setCellValue('J' . $newRowIndex, $dato->tipo);
            $sheet->setCellValue('K' . $newRowIndex, $dato->ent_nac);
            $sheet->setCellValue('L' . $newRowIndex, $dato->ent_int);
            $sheet->setCellValue('M' . $newRowIndex, $dato->sal_nac);
            $sheet->setCellValue('N' . $newRowIndex, $dato->sal_int);
            $sheet->setCellValue('O' . $newRowIndex, $dato->fecha_inicio);
            $sheet->setCellValue('P' . $newRowIndex, $dato->fecha_final);
            $sheet->setCellValue('Q' . $newRowIndex, $dato->duracion);

            $sheet->getStyle('A' . $newRowIndex . ':Q' . $newRowIndex)->getAlignment()->setWrapText(true);
            $sheet->getStyle('A' . $newRowIndex . ':Q' . $newRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $newRowIndex . ':Q' . $newRowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $newRowIndex . ':Q' . $newRowIndex)->applyFromArray([
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
