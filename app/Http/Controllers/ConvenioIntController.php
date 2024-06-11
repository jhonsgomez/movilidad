<?php

namespace App\Http\Controllers;

use App\Exports\ConvenioIntExport;
use App\Exports\ConvenioAllUsuariosExport;
use App\Models\ConvenioInt;
use App\Models\ConvenioUsuarios;
use App\Models\ConvenioNac;
use App\Models\InstEntInt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ConvenioIntController extends Controller
{
    public function index()
    {
        $type_convenio = session('type_convenio');

        $convInts = DB::table('convenio_ints')
            ->join('inst_ent_ints', 'convenio_ints.instEntInt_id', '=', 'inst_ent_ints.id')
            ->select('convenio_ints.*', 'inst_ent_ints.nombre', 'inst_ent_ints.pais')
            ->where('convenio_ints.estado', '=', 1)
            ->where('convenio_ints.tipo', '=', $type_convenio)
            ->get();

        $conveniosConUsuarios = [];

        foreach ($convInts as $convenio) {
            $usuarios = DB::table('convenio_usuarios')
                ->join('convenio_ints', 'convenio_usuarios.convenio_id', '=', 'convenio_ints.id')
                ->join('programas_academicos', 'convenio_usuarios.programa_academico', '=', 'programas_academicos.id')
                ->select('convenio_usuarios.*', 'programas_academicos.nombre AS nombre_programa')
                ->where('convenio_usuarios.convenio_id', '=', $convenio->id)
                ->where('convenio_usuarios.nac_int', '=', 1)
                ->get();

            $conveniosConUsuarios[$convenio->id] = [
                'convenio' => $convenio,
                'usuarios' => $usuarios
            ];
        }

        $programas = DB::table('programas_academicos')
            ->select('programas_academicos.*')
            ->get();

        return view('convenios.indexint', compact(['conveniosConUsuarios', 'programas']));
    }

    public function create()
    {
        $instEntInt = InstEntInt::where('estado', 1)->get();
        $programas = DB::table('programas_academicos')
            ->select('programas_academicos.*')
            ->get();
        return view('convenios.createint', compact(['instEntInt', 'programas']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'conv_fechaInicio' => 'required',
            'conv_tipo' => 'required',
            'conv_objeto' => 'required',
            'conv_vigencia' => 'required',
            'conv_docsoporte' => 'required',
            'conv_instEntInt' => 'required',
            'conv_result' => 'required',
            'usuarios_convenio' => 'required'
        ]);

        $files = [];

        if ($request->hasFile('conv_docsoporte')) {
            foreach ($request->file('conv_docsoporte') as $file) {
                $name = time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('files/conveniosInt'), $name);
                $files[] = $name;
            }
        }

        $c_convs = ConvenioInt::get('codigo');
        $conv = new ConvenioInt();

        if ($c_convs->isEmpty()) {
            $codigo = [310, 1000];
            $conv->codigo = implode('-', $codigo);
        } else {
            $last = $c_convs->last();
            $codigo = explode('-', $last->codigo);
            $codigo[1] += 1;
            $conv->codigo = implode('-', $codigo);
        }

        $usuariosJson = $request->post('usuarios_convenio');
        $usuariosArray = json_decode($usuariosJson, true);

        if (is_array($usuariosArray)) { 
            $conv->fechaInicio = $request->post('conv_fechaInicio');
            $conv->tipo = $request->post('conv_tipo');
            $conv->breve_objeto = $request->post('conv_objeto');
            $conv->activo = "Sí";
            $conv->vigencia = $request->post('conv_vigencia');
            $conv->docSoportes = implode(',', $files);
            $conv->estado = 1;
            $conv->instEntInt_id = $request->post('conv_instEntInt');
            $conv->user_id = auth()->user()->id;
            $conv->resultados_concretos = $request->post('conv_result');
            $conv->n_usuarios = count($usuariosArray);
            $conv->es_nacional = 0;

            $conv->save();

            foreach ($usuariosArray as $usuario) {
                ConvenioUsuarios::create([
                    'documento' => $usuario['documento'],
                    'nombre' => $usuario['nombre'],
                    'programa_academico' => $usuario['programa_academico'],
                    'periodo_academico' => $usuario['periodo_academico'],
                    'correo_institucional' => $usuario['correo_institucional'],
                    'numero_telefono' => $usuario['numero_telefono'],
                    'fecha_inicio' => $usuario['fecha_inicio'],
                    'fecha_terminacion' => $usuario['fecha_terminacion'],
                    'duracion' => $usuario['duracion'],
                    'supervisor' => $usuario['supervisor'],
                    'nac_int' => 1,
                    'convenio_id' => $conv->id
                ]);
            }

            return redirect()
            ->route('login.activites')
            ->with('success', 'Convenio con código ' . implode("-", $codigo) . ' creado correctamente!');
        } else {
            return redirect()
            ->back()
            ->withErrors(['usuarios' => 'Error al procesar la lista de usuarios.']);
        }
    }

    public function download($file)
    {
        return response()->download(public_path('files/conveniosInt/' . $file));
    }

    public function edit($conv_id)
    {
        $instEntInt = InstEntInt::where('estado', 1)->get();
        $convs = ConvenioInt::findOrFail($conv_id);
        return view('convenios.editint', compact(['instEntInt', 'convs']));
    }

    public function update(Request $request, $conv_id)
    {
        $request->validate([
            'conv_fechaInicio' => 'required',
            'conv_tipo' => 'required',
            'conv_instEntInt' => 'required',
            'conv_vigencia' => 'required',
            'conv_objeto' => 'required',
            'conv_result' => 'required',
            'conv_activo' => 'required'
        ]);

        $conv = ConvenioInt::findOrFail($conv_id);
        $conv->instEntInt_id = $request->conv_instEntInt;
        $conv->tipo = $request->conv_tipo;
        $conv->breve_objeto = $request->conv_objeto;
        $conv->resultados_concretos = $request->conv_result;
        $conv->fechaInicio = $request->conv_fechaInicio;
        $conv->vigencia = $request->conv_vigencia;
        $conv->activo = $request->conv_activo;

        $conv->save();

        return redirect('/activities/cons_convenios_int')
            ->with('success', 'Convenio actualizado correctamente!');
    }

    public function destroy($conv_id)
    {
        $conv = ConvenioInt::findOrFail($conv_id);
        $conv->estado = 0;
        $conv->save();

        DB::table('convenio_usuarios')
            ->where('convenio_id', '=', $conv_id)
            ->where('nac_int', '=', 1)
            ->delete();

        return redirect('/activities/cons_convenios_int')
            ->with('success', 'Convenio con código ' . $conv->codigo . ' eliminado correctamente!');
    }

    public function exporting(Request $request)
    {
        $from = $request->input('convInt_initialDate');
        $to = $request->input('convInt_finalDate');
        $type_reporte = $request->input('type_reporte');

        if ($from == Null && $to == Null) {
            $from = "0001-01-01";
            $to = "9999-12-31";
        } elseif ($from != "" && $to == "") {
            $to = "9999-12-31";
        }

        $archivoExcel = public_path('files\excel\FormatoConvenios.xlsx');
        $spreadsheet = IOFactory::load($archivoExcel);

        $sheet = $spreadsheet->getActiveSheet();

        if ($type_reporte == 'Todos') {
            $datos = ConvenioNac::query()
                        ->join('inst_ent_nacs', 'convenio_nacs.instEntNac_id', '=', 'inst_ent_nacs.id')
                        ->select(
                            DB::raw("CONCAT('NAC-', convenio_nacs.id) AS new_id"),
                            DB::raw('UPPER(inst_ent_nacs.nombre) AS institucion'),
                            DB::raw('convenio_nacs.tipo AS tipo'),
                            DB::raw('CONCAT(UCASE(LEFT(convenio_nacs.breve_objeto, 1)), LCASE(SUBSTRING(convenio_nacs.breve_objeto, 2))) AS breve_objeto'),
                            DB::raw('CONCAT(UCASE(LEFT(convenio_nacs.resultados_concretos, 1)), LCASE(SUBSTRING(convenio_nacs.resultados_concretos, 2))) AS resultados_concretos'),
                            DB::raw("CONCAT(DATEDIFF(convenio_nacs.vigencia, convenio_nacs.fechaInicio) DIV 365, ' Año(s) ', 
                                    DATEDIFF(convenio_nacs.vigencia, convenio_nacs.fechaInicio) % 365 DIV 7, ' semana(s) ', 
                                    DATEDIFF(convenio_nacs.vigencia, convenio_nacs.fechaInicio) % 7, ' día(s)') AS vigencia"),
                            DB::raw("IF(convenio_nacs.activo = 'Si', 'Activo', '') AS activo"),
                            DB::raw("IF(convenio_nacs.n_usuarios = 0, 'No Aplica', convenio_nacs.n_usuarios) AS n_usuarios"),
                            DB::raw("IF(convenio_nacs.es_nacional = 1, 'Nacional', 'Internacional') AS es_nacional")
                        )
                        ->whereDate('convenio_nacs.created_at', ">=", $from)
                        ->whereDate('convenio_nacs.created_at', "<=", $to)
                        ->where('convenio_nacs.estado', 1)
                        ->get();

            $datos_2 = ConvenioInt::query()
                        ->join('inst_ent_ints', 'convenio_ints.instEntInt_id', '=', 'inst_ent_ints.id')
                        ->select(
                            DB::raw("CONCAT('INT-', convenio_ints.id) AS new_id"),
                            DB::raw('UPPER(inst_ent_ints.nombre) AS institucion'),
                            DB::raw('convenio_ints.tipo AS tipo'),
                            DB::raw('CONCAT(UCASE(LEFT(convenio_ints.breve_objeto, 1)), LCASE(SUBSTRING(convenio_ints.breve_objeto, 2))) AS breve_objeto'),
                            DB::raw('CONCAT(UCASE(LEFT(convenio_ints.resultados_concretos, 1)), LCASE(SUBSTRING(convenio_ints.resultados_concretos, 2))) AS resultados_concretos'),
                            DB::raw("CONCAT(DATEDIFF(convenio_ints.vigencia, convenio_ints.fechaInicio) DIV 365, ' Año(s) ', 
                                    DATEDIFF(convenio_ints.vigencia, convenio_ints.fechaInicio) % 365 DIV 7, ' semana(s) ', 
                                    DATEDIFF(convenio_ints.vigencia, convenio_ints.fechaInicio) % 7, ' día(s)') AS vigencia"),
                            DB::raw("IF(convenio_ints.activo = 'Si', 'Activo', '') AS activo"),
                            DB::raw("IF(convenio_ints.n_usuarios = 0, 'No Aplica', convenio_ints.n_usuarios) AS n_usuarios"),
                            DB::raw("IF(convenio_ints.es_nacional = 1, 'Nacional', 'Internacional') AS es_nacional")
                        )
                        ->whereDate('convenio_ints.created_at', ">=", $from)
                        ->whereDate('convenio_ints.created_at', "<=", $to)
                        ->where('convenio_ints.estado', 1)
                        ->get();

            $lastRow = $sheet->getHighestRow();

            $newRowIndex = $lastRow + 1;

            foreach ($datos as $dato) {
                $sheet->setCellValue('A' . $newRowIndex, $dato->new_id);
                $sheet->setCellValue('B' . $newRowIndex, $dato->institucion);
                $sheet->setCellValue('C' . $newRowIndex, $dato->tipo);
                $sheet->setCellValue('D' . $newRowIndex, $dato->breve_objeto);
                $sheet->setCellValue('E' . $newRowIndex, $dato->resultados_concretos);
                $sheet->setCellValue('F' . $newRowIndex, $dato->vigencia);
                $sheet->setCellValue('G' . $newRowIndex, $dato->activo);
                $sheet->setCellValue('H' . $newRowIndex, $dato->n_usuarios);
                $sheet->setCellValue('I' . $newRowIndex, $dato->es_nacional);

                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setWrapText(true);
                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                
                $newRowIndex++;
            }

            foreach ($datos_2 as $dato) {
                $sheet->setCellValue('A' . $newRowIndex, $dato->new_id);
                $sheet->setCellValue('B' . $newRowIndex, $dato->institucion);
                $sheet->setCellValue('C' . $newRowIndex, $dato->tipo);
                $sheet->setCellValue('D' . $newRowIndex, $dato->breve_objeto);
                $sheet->setCellValue('E' . $newRowIndex, $dato->resultados_concretos);
                $sheet->setCellValue('F' . $newRowIndex, $dato->vigencia);
                $sheet->setCellValue('G' . $newRowIndex, $dato->activo);
                $sheet->setCellValue('H' . $newRowIndex, $dato->n_usuarios);
                $sheet->setCellValue('I' . $newRowIndex, $dato->es_nacional);

                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setWrapText(true);
                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->applyFromArray([
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
                header('Content-Disposition: attachment;filename="UTS - Reporte de convenios.xlsx"');

                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            });

            return $response;
        } else if ($type_reporte == 'Usuarios') {
            return Excel::download(new ConvenioAllUsuariosExport(), 'UTS - Reporte de Usuarios.xlsx');
        } else {
            $datos = ConvenioNac::query()
                    ->join('inst_ent_nacs', 'convenio_nacs.instEntNac_id', '=', 'inst_ent_nacs.id')
                    ->select(
                        DB::raw("CONCAT('NAC-', convenio_nacs.id) AS new_id"),
                        DB::raw('UPPER(inst_ent_nacs.nombre) AS institucion'),
                        DB::raw('convenio_nacs.tipo AS tipo'),
                        DB::raw('CONCAT(UCASE(LEFT(convenio_nacs.breve_objeto, 1)), LCASE(SUBSTRING(convenio_nacs.breve_objeto, 2))) AS breve_objeto'),
                        DB::raw('CONCAT(UCASE(LEFT(convenio_nacs.resultados_concretos, 1)), LCASE(SUBSTRING(convenio_nacs.resultados_concretos, 2))) AS resultados_concretos'),
                        DB::raw("CONCAT(DATEDIFF(convenio_nacs.vigencia, convenio_nacs.fechaInicio) DIV 365, ' Año(s) ', 
                                DATEDIFF(convenio_nacs.vigencia, convenio_nacs.fechaInicio) % 365 DIV 7, ' semana(s) ', 
                                DATEDIFF(convenio_nacs.vigencia, convenio_nacs.fechaInicio) % 7, ' día(s)') AS vigencia"),
                        DB::raw("IF(convenio_nacs.activo = 'Si', 'Activo', '') AS activo"),
                        DB::raw("IF(convenio_nacs.n_usuarios = 0, 'No Aplica', convenio_nacs.n_usuarios) AS n_usuarios"),
                        DB::raw("IF(convenio_nacs.es_nacional = 1, 'Nacional', 'Internacional') AS es_nacional")
                    )
                    ->whereDate('convenio_nacs.created_at', ">=", $from)
                    ->whereDate('convenio_nacs.created_at', "<=", $to)
                    ->where('convenio_nacs.tipo', '=', $type_reporte)
                    ->where('convenio_nacs.estado', 1)
                    ->get();

            $datos_2 = ConvenioInt::query()
                        ->join('inst_ent_ints', 'convenio_ints.instEntInt_id', '=', 'inst_ent_ints.id')
                        ->select(
                            DB::raw("CONCAT('INT-', convenio_ints.id) AS new_id"),
                            DB::raw('UPPER(inst_ent_ints.nombre) AS institucion'),
                            DB::raw('convenio_ints.tipo AS tipo'),
                            DB::raw('CONCAT(UCASE(LEFT(convenio_ints.breve_objeto, 1)), LCASE(SUBSTRING(convenio_ints.breve_objeto, 2))) AS breve_objeto'),
                            DB::raw('CONCAT(UCASE(LEFT(convenio_ints.resultados_concretos, 1)), LCASE(SUBSTRING(convenio_ints.resultados_concretos, 2))) AS resultados_concretos'),
                            DB::raw("CONCAT(DATEDIFF(convenio_ints.vigencia, convenio_ints.fechaInicio) DIV 365, ' Año(s) ', 
                                    DATEDIFF(convenio_ints.vigencia, convenio_ints.fechaInicio) % 365 DIV 7, ' semana(s) ', 
                                    DATEDIFF(convenio_ints.vigencia, convenio_ints.fechaInicio) % 7, ' día(s)') AS vigencia"),
                            DB::raw("IF(convenio_ints.activo = 'Si', 'Activo', '') AS activo"),
                            DB::raw("IF(convenio_ints.n_usuarios = 0, 'No Aplica', convenio_ints.n_usuarios) AS n_usuarios"),
                            DB::raw("IF(convenio_ints.es_nacional = 1, 'Nacional', 'Internacional') AS es_nacional")
                        )
                        ->whereDate('convenio_ints.created_at', ">=", $from)
                        ->whereDate('convenio_ints.created_at', "<=", $to)
                        ->where('convenio_ints.tipo', '=', $type_reporte)
                        ->where('convenio_ints.estado', 1)
                        ->get();

            $lastRow = $sheet->getHighestRow();

            $newRowIndex = $lastRow + 1;

            foreach ($datos as $dato) {
                $sheet->setCellValue('A' . $newRowIndex, $dato->new_id);
                $sheet->setCellValue('B' . $newRowIndex, $dato->institucion);
                $sheet->setCellValue('C' . $newRowIndex, $dato->tipo);
                $sheet->setCellValue('D' . $newRowIndex, $dato->breve_objeto);
                $sheet->setCellValue('E' . $newRowIndex, $dato->resultados_concretos);
                $sheet->setCellValue('F' . $newRowIndex, $dato->vigencia);
                $sheet->setCellValue('G' . $newRowIndex, $dato->activo);
                $sheet->setCellValue('H' . $newRowIndex, $dato->n_usuarios);
                $sheet->setCellValue('I' . $newRowIndex, $dato->es_nacional);

                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setWrapText(true);
                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                
                $newRowIndex++;
            }

            foreach ($datos_2 as $dato) {
                $sheet->setCellValue('A' . $newRowIndex, $dato->new_id);
                $sheet->setCellValue('B' . $newRowIndex, $dato->institucion);
                $sheet->setCellValue('C' . $newRowIndex, $dato->tipo);
                $sheet->setCellValue('D' . $newRowIndex, $dato->breve_objeto);
                $sheet->setCellValue('E' . $newRowIndex, $dato->resultados_concretos);
                $sheet->setCellValue('F' . $newRowIndex, $dato->vigencia);
                $sheet->setCellValue('G' . $newRowIndex, $dato->activo);
                $sheet->setCellValue('H' . $newRowIndex, $dato->n_usuarios);
                $sheet->setCellValue('I' . $newRowIndex, $dato->es_nacional);

                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setWrapText(true);
                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A' . $newRowIndex . ':I' . $newRowIndex)->applyFromArray([
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
                header('Content-Disposition: attachment;filename="UTS - Reporte de convenios.xlsx"');

                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            });

            return $response;
        }
    }
}
