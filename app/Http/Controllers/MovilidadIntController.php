<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InstEntInt;
use App\Models\Movilidad;

class MovilidadIntController extends Controller
{
    public function index()
    {
        $movilidades = DB::table('movilidad')
            ->join('inst_ent_ints', 'movilidad.inst_ent_ints', '=', 'inst_ent_ints.id')
            ->select('movilidad.*', 'inst_ent_ints.nombre AS entidad_origen',
                DB::raw("CONCAT(DATEDIFF(movilidad.fecha_final, movilidad.fecha_inicio), ' días') AS duracion")
            )
            ->where('movilidad.nac_ext', '=', 1)
            ->get();

        $movilidadesConActividades = [];
        
        foreach ($movilidades as $movilidad) {
            $actividades = DB::table('actividades')
                ->join('inst_ent_ints', 'actividades.inst_ent_ints', '=', 'inst_ent_ints.id')
                ->select('actividades.*', 'inst_ent_ints.nombre AS ies')
                ->where('actividades.movilidad', '=', $movilidad->id)
                ->get();
    
            $movilidadesConActividades[$movilidad->id] = [
                'movilidad' => $movilidad,
                'actividades' => $actividades
            ];
        }

        return view('movilidades.indexint', compact('movilidadesConActividades'));
    }

    public function create()
    {
        $instituciones = InstEntInt::where('estado', 1)->get();
        return view('movilidades.createint', compact('instituciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'documento' => 'required',
            'nombre' => 'required',
            'est_pro' => 'required',
            'inst_ent_ints' => 'required',
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
                $file->move(public_path('files/movilidadInt'), $name);
                $files[] = $name;
            }
        }

        $movilidad = new Movilidad();

        $movilidad->documento = $request->post('documento');
        $movilidad->nombre = $request->post('nombre');
        $movilidad->est_pro = $request->post('est_pro');
        $movilidad->inst_ent_ints = $request->post('inst_ent_ints');
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

        return redirect()->route('movilidades_int.index')
            ->with('success', 'Movilidad creada correctamente!');
    }

    public function download($file)
    {
        return response()->download(public_path('files/movilidadInt/' . $file));
    }

    public function edit($mov_id)
    {
        $instituciones = InstEntInt::where('estado', 1)->get();
        $movilidad = Movilidad::findOrFail($mov_id);

        return view('movilidades.editint', compact(['instituciones', 'movilidad']));
    }

    public function update(Request $request, $mov_id)
    {
        $request->validate([
            'documento' => 'required',
            'nombre' => 'required',
            'est_pro' => 'required',
            'inst_ent_ints' => 'required',
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
        $movilidad->inst_ent_ints = $request->inst_ent_ints;
        $movilidad->pais = $request->pais;
        $movilidad->objeto = $request->objeto;
        $movilidad->resultados = $request->resultados;
        $movilidad->pres_virt = $request->pres_virt;
        $movilidad->ent_sal = $request->ent_sal;
        $movilidad->nac_ext = $request->nac_ext;
        $movilidad->fecha_inicio = $request->fecha_inicio;
        $movilidad->fecha_final = $request->fecha_final;
    
        $movilidad->save();

        return redirect()->route('movilidades_int.index')
            ->with('success', 'Movilidad editada correctamente!');
    }

    public function destroy($mov_id)
    {
        $movilidad = Movilidad::findOrFail($mov_id);
        $movilidad->delete();
        
        return redirect()->route('movilidades_int.index')
            ->with('success', 'Movilidad eliminada correctamente!');
    }
}
