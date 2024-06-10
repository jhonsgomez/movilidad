<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\ProgramaAcademico;
use App\Models\AsistentesActividades;
use Illuminate\Support\Facades\DB;
use App\Exports\AsistentesActividadesExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class AsistentesActividadesController extends Controller
{
    public function index(Request $request, $actividad_id) {
        $actividad = Actividad::findOrFail($actividad_id);
        $asistentes = DB::table('actividades_asistentes')
            ->join('actividades', 'actividades_asistentes.actividad_id', '=', 'actividades.id')
            ->join('programas_academicos', 'actividades_asistentes.programa_academico', '=', 'programas_academicos.id')
            ->select('actividades_asistentes.*', 'programas_academicos.nombre AS nombre_programa')
            ->where('actividades_asistentes.actividad_id', '=', $actividad_id)
            ->get();

        $programas = DB::table('programas_academicos')
            ->select('programas_academicos.*')
            ->get();

        return view('asistentes.index', compact(['actividad', 'asistentes', 'programas']));
    }

    public function store_one(Request $request) {
        $request->validate([
            'documento' => 'required',
            'nombre' => 'required',
            'programa_academico' => 'required',
            'periodo_academico' => 'required',
            'correo_institucional' => 'required',
            'actividad_id' => 'required'
        ]);

        $asistente = new AsistentesActividades();

        $asistente->documento = $request->post('documento');
        $asistente->nombre = $request->post('nombre');
        $asistente->programa_academico = $request->post('programa_academico');
        $asistente->periodo_academico = $request->post('periodo_academico');
        $asistente->correo_institucional = $request->post('correo_institucional');
        $asistente->numero_telefono = $request->post('numero_telefono');
        $asistente->actividad_id = $request->post('actividad_id');

        $asistente->save();
        
        return redirect(route('movilidades.get_asistentes', $request->post('actividad_id')))
            ->with('success', 'Asistente registrado correctamente!');
    }

    public function store_many(Request $request) {
        $request->validate([
            'actividad_id' => 'required',
            'file' => 'required'
        ]);

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Error al cargar el archivo.'], 400);
        }

        $fileContent = file_get_contents($file->path());
        $fileContentUtf8 = iconv(mb_detect_encoding($fileContent, mb_detect_order(), true), "UTF-8", $fileContent);

        $lines = explode("\n", $fileContentUtf8);
        $data = array_map(function($line) {
            return str_getcsv($line, ';');
        }, $lines);

        $data = array_filter($data, function ($row) {
            return count($row) >= 5 && !empty($row[0]);
        });

        $header = array_shift($data);

        $asistentes = [];
        foreach ($data as $row) {
            $documento = $row[0];
            $nombre = $row[1];
            $programa_academico_nombre = $row[2];
            $periodo_academico = $row[3];
            $correo_institucional = $row[4];
            $numero_telefono = ($row[5] == '') ? null : $row[5];

            $programa_academico = DB::table('programas_academicos')
                ->select('programas_academicos.*')
                ->where('programas_academicos.nombre', '=', $programa_academico_nombre)
                ->first();

            if (!$programa_academico) {
                return response()->json(['error' => "El programa académico '$programa_academico_nombre' no existe."], 400);
            }

            $asistentes[] = [
                'documento' => $documento,
                'nombre' => $nombre,
                'programa_academico' => $programa_academico->id,
                'periodo_academico' => $periodo_academico,
                'correo_institucional' => $correo_institucional,
                'numero_telefono' => $numero_telefono,
                'actividad_id' => $request->post('actividad_id'),
            ];
        }

        DB::table('actividades_asistentes')->insert($asistentes);

        return redirect(route('movilidades.get_asistentes', $request->post('actividad_id')))
            ->with('success', 'Asistentes registrados correctamente!');
    }

    public function download($file) {
        return response()->download(public_path('files/excel/' . $file));
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required',
            'documento' => 'required',
            'nombre' => 'required',
            'programa_academico' => 'required',
            'periodo_academico' => 'required',
            'correo_institucional' => 'required',
            'actividad_id' => 'required'
        ]);

        $asistente = AsistentesActividades::findOrFail($request->post('id'));

        $asistente->documento = $request->post('documento');
        $asistente->nombre = $request->post('nombre');
        $asistente->programa_academico = $request->post('programa_academico');
        $asistente->periodo_academico = $request->post('periodo_academico');
        $asistente->correo_institucional = $request->post('correo_institucional');
        $asistente->numero_telefono = $request->post('numero_telefono');
        $asistente->actividad_id = $request->post('actividad_id');

        $asistente->save();

        return redirect(route('movilidades.get_asistentes', $request->post('actividad_id')))
            ->with('success', 'Asistente editado correctamente!');
    }

    public function destroy(Request $request) {
        $request->validate([
            'id' => 'required'
        ]);

        $asistente = AsistentesActividades::findOrFail($request->post('id'));
        $actividad_id = $asistente->actividad_id;

        $asistente->delete();

        return redirect(route('movilidades.get_asistentes', $actividad_id))
            ->with('success', 'Asistente eliminado correctamente!');
    }

    public function report(Request $request) {
        $request->validate([
            'actividad_id' => 'required'
        ]);

        return Excel::download(new AsistentesActividadesExport($request->post('actividad_id')), 'UTS - Reporte de Asistencia.xlsx');
    }
}
