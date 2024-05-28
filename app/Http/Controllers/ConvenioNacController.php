<?php

namespace App\Http\Controllers;

use App\Exports\ConvenioNacExport;
use App\Models\ConvenioNac;
use App\Models\ConvenioInt;
use App\Models\InstEntNac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


class ConvenioNacController extends Controller
{
    private $convenioNacExport;

    public function __construct(ConvenioNacExport $convenioNacExport)
    {
        $this->convenioNacExport = $convenioNacExport;
    }
    
    public function index(Request $request)
    {
        $type_convenio = session('type_convenio');

        $convNacs = DB::table('convenio_nacs')
            ->join('inst_ent_nacs', 'convenio_nacs.instEntNac_id', '=', 'inst_ent_nacs.id')
            ->select('convenio_nacs.*', 'inst_ent_nacs.nombre', 'inst_ent_nacs.ciudad')
            ->where('convenio_nacs.estado', '=', 1)
            ->where('convenio_nacs.tipo', '=', $type_convenio)
            ->get();
        return view('convenios.indexnac', compact('convNacs'));
    }

    public function create()
    {
        $instEntNacs = InstEntNac::where('estado', 1)->get();
        return view('convenios.createnac', compact('instEntNacs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'conv_fechaInicioNac' => 'required',
            'conv_tipoNac' => 'required',
            'conv_superNac' => 'required',
            'con_instEntNac' => 'required',
            'conv_vigenciaNac' => 'required',
            'conv_docsoporteNac' => 'required',
            'conv_objetoNac' => 'required',
            'conv_resultNac' => 'required',
            'conv_nUsuariosNac' => 'required',
        ]);

        $files = [];

        if ($request->hasFile('conv_docsoporteNac')) {
            foreach ($request->file('conv_docsoporteNac') as $file) {
                $name = time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('files/conveniosNac'), $name);
                $files[] = $name;
            }
        }

        $c_convs = ConvenioNac::get('codigo');

        $convNac = new ConvenioNac();

        if ($c_convs->isEmpty()) {
            $codigo = [310, 1000];
            $convNac->codigo = implode('-', $codigo);
        } else {
            $last = $c_convs->last();
            $codigo = explode('-', $last->codigo);
            $codigo[1] += 1;
            $convNac->codigo = implode('-', $codigo);
        }

        $convNac->instEntNac_id = $request->post('con_instEntNac');
        $convNac->tipo = $request->post('conv_tipoNac');
        $convNac->breve_objeto = $request->post('conv_objetoNac');
        $convNac->resultados_concretos = $request->post('conv_resultNac');
        $convNac->fechaInicio = $request->post('conv_fechaInicioNac');
        $convNac->vigencia = $request->post('conv_vigenciaNac');
        $convNac->n_usuarios = $request->post('conv_nUsuariosNac');
        $convNac->supervisor = $request->post('conv_superNac');
        $convNac->estado = 1;
        $convNac->es_nacional = 1;
        $convNac->docSoportes = implode(',', $files);

        $convNac->activo = "Sí";
        $convNac->user_id = auth()->user()->id;

        $convNac->save();

        return redirect()->route('login.activites')
            ->with('success', 'Convenio con código ' . implode("-", $codigo) . ' creado correctamente!');
    }


    public function download($file)
    {
        return response()->download(public_path('files/conveniosNac/' . $file));
    }


    public function edit($conv_id)
    {
        $instEntNacs = InstEntNac::where('estado', 1)->get();
        $convs = ConvenioNac::findOrFail($conv_id);
        return view('convenios.editnac', compact(['instEntNacs', 'convs']));
    }


    public function update(Request $request, $conv_id)
    {

        $request->validate([
            'conv_fechaInicioNac' => 'required',
            'conv_tipoNac' => 'required',
            'conv_superNac' => 'required',
            'con_instEntNac' => 'required',
            'conv_vigenciaNac' => 'required',
            'conv_objetoNac' => 'required',
            'conv_resultNac' => 'required',
            'conv_nUsuariosNac' => 'required',
        ]);

        $conv = ConvenioNac::findOrFail($conv_id);
        $conv->instEntNac_id = $request->con_instEntNac;
        $conv->tipo = $request->conv_tipoNac;
        $conv->breve_objeto = $request->conv_objetoNac;
        $conv->resultados_concretos = $request->conv_resultNac;
        $conv->fechaInicio = $request->conv_fechaInicioNac;
        $conv->vigencia = $request->conv_vigenciaNac;
        $conv->n_usuarios = $request->conv_nUsuariosNac;
        $conv->supervisor = $request->conv_superNac;
        $conv->activo = $request->conv_activoNac;

        $conv->save();

        return redirect('/activities/cons_convenios_nac')
            ->with('success', 'Convenio actualizado correctamente!');
    }


    public function destroy($conv_id)
    {
        $conv = ConvenioNac::findOrFail($conv_id);
        $conv->estado = 0;
        $conv->save();
        return redirect('/activities/cons_convenios_nac')
            ->with('success', 'Convenio con código ' . $conv->codigo . ' eliminado correctamente!');
    }

    public function exporting(Request $request)
    {  
        $from = $request->input('convNac_initialDate');
        $to = $request->input('convNac_finalDate');
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
                $sheet->setCellValue('C' . $newRowIndex, $dato->breve_objeto);
                $sheet->setCellValue('D' . $newRowIndex, $dato->resultados_concretos);
                $sheet->setCellValue('E' . $newRowIndex, $dato->vigencia);
                $sheet->setCellValue('F' . $newRowIndex, $dato->activo);
                $sheet->setCellValue('G' . $newRowIndex, $dato->n_usuarios);
                $sheet->setCellValue('H' . $newRowIndex, $dato->es_nacional);

                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setWrapText(true);
                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->applyFromArray([
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
                $sheet->setCellValue('C' . $newRowIndex, $dato->breve_objeto);
                $sheet->setCellValue('D' . $newRowIndex, $dato->resultados_concretos);
                $sheet->setCellValue('E' . $newRowIndex, $dato->vigencia);
                $sheet->setCellValue('F' . $newRowIndex, $dato->activo);
                $sheet->setCellValue('G' . $newRowIndex, $dato->n_usuarios);
                $sheet->setCellValue('H' . $newRowIndex, $dato->es_nacional);

                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setWrapText(true);
                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->applyFromArray([
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
        } else {
            $datos = ConvenioNac::query()
                    ->join('inst_ent_nacs', 'convenio_nacs.instEntNac_id', '=', 'inst_ent_nacs.id')
                    ->select(
                        DB::raw("CONCAT('NAC-', convenio_nacs.id) AS new_id"),
                        DB::raw('UPPER(inst_ent_nacs.nombre) AS institucion'),
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
                $sheet->setCellValue('C' . $newRowIndex, $dato->breve_objeto);
                $sheet->setCellValue('D' . $newRowIndex, $dato->resultados_concretos);
                $sheet->setCellValue('E' . $newRowIndex, $dato->vigencia);
                $sheet->setCellValue('F' . $newRowIndex, $dato->activo);
                $sheet->setCellValue('G' . $newRowIndex, $dato->n_usuarios);
                $sheet->setCellValue('H' . $newRowIndex, $dato->es_nacional);

                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setWrapText(true);
                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->applyFromArray([
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
                $sheet->setCellValue('C' . $newRowIndex, $dato->breve_objeto);
                $sheet->setCellValue('D' . $newRowIndex, $dato->resultados_concretos);
                $sheet->setCellValue('E' . $newRowIndex, $dato->vigencia);
                $sheet->setCellValue('F' . $newRowIndex, $dato->activo);
                $sheet->setCellValue('G' . $newRowIndex, $dato->n_usuarios);
                $sheet->setCellValue('H' . $newRowIndex, $dato->es_nacional);

                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setWrapText(true);
                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A' . $newRowIndex . ':H' . $newRowIndex)->applyFromArray([
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
