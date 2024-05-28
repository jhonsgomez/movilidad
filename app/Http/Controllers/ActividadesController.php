<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstEntNac;
use App\Models\InstEntInt;

use App\Models\Movilidad;
use App\Models\Actividad;

class ActividadesController extends Controller
{
    public function create($mov_id)
    {
        $movilidad = Movilidad::findOrFail($mov_id);
        $instituciones;
        if ($movilidad->nac_ext == 0) $instituciones = InstEntNac::where('estado', 1)->get();
        else $instituciones = InstEntInt::where('estado', 1)->get();
    
        return view('actividades.create', compact(['movilidad', 'instituciones']));
    }

    public function store(Request $request, $mov_id)
    {
        $movilidad = Movilidad::findOrFail($mov_id);

        if ($movilidad->nac_ext == 0)
        {
            $request->validate([
                'tipo' => 'required',
                'descripcion_tipo' => 'required',
                'resultados' => 'required',
                'responsable' => 'required',
                'documento' => 'required',
                'tipo_empleado' => 'required',
                'descripcion_tipo_empleado' => 'required',
                'pais' => 'required',
                'inst_ent_nacs' => 'required',
                'movilidad' => 'required',
            ]);
        } else {
            $request->validate([
                'tipo' => 'required',
                'descripcion_tipo' => 'required',
                'resultados' => 'required',
                'responsable' => 'required',
                'documento' => 'required',
                'tipo_empleado' => 'required',
                'descripcion_tipo_empleado' => 'required',
                'pais' => 'required',
                'inst_ent_ints' => 'required',
                'movilidad' => 'required',
            ]);
        }

        $files = [];

        if ($request->hasFile('doc_soporte')) {
            foreach ($request->file('doc_soporte') as $file) {
                $name = time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('files/actividades'), $name);
                $files[] = $name;
            }
        }

        $actividad = new Actividad();

        $actividad->tipo = $request->post('tipo');
        $actividad->descripcion_tipo = $request->post('descripcion_tipo');
        $actividad->resultados = $request->post('resultados');
        $actividad->responsable = $request->post('responsable');
        $actividad->documento = $request->post('documento');
        $actividad->tipo_empleado = $request->post('tipo_empleado');
        $actividad->descripcion_tipo_empleado = $request->post('descripcion_tipo_empleado');
        $actividad->pais = $request->post('pais');
        if ($movilidad->nac_ext == 0) $actividad->inst_ent_nacs = $request->post('inst_ent_nacs');
        else $actividad->inst_ent_ints = $request->post('inst_ent_ints');
        $actividad->movilidad = $request->post('movilidad');
        $actividad->doc_soporte = implode(',', $files);

        $actividad->save();

        if ($movilidad->nac_ext == 0) return redirect()->route('movilidades_nac.index')->with('success', 'Actividad creada correctamente!');
        else return redirect()->route('movilidades_int.index')->with('success', 'Actividad creada correctamente!');
    }

    public function edit($act_id)
    {
        $actividad = Actividad::findOrFail($act_id);
        $movilidad = Movilidad::findOrFail($actividad->movilidad);
        $instituciones;

        if ($movilidad->nac_ext == 0) $instituciones = InstEntNac::where('estado', 1)->get();
        else $instituciones = InstEntInt::where('estado', 1)->get();

        return view('actividades.edit', compact(['actividad', 'movilidad', 'instituciones']));
    }

    public function details($act_id)
    {
        $actividad = Actividad::findOrFail($act_id);
        $movilidad = Movilidad::findOrFail($actividad->movilidad);
        $instituciones;

        if ($movilidad->nac_ext == 0) $instituciones = InstEntNac::where('estado', 1)->get();
        else $instituciones = InstEntInt::where('estado', 1)->get();

        return view('actividades.details', compact(['actividad', 'movilidad', 'instituciones']));
    }

    public function update(Request $request, $act_id)
    {
        $actividad = Actividad::findOrFail($act_id);
        $movilidad = Movilidad::findOrFail($actividad->movilidad);

        if ($movilidad->nac_ext == 0)
        {
            $request->validate([
                'tipo' => 'required',
                'descripcion_tipo' => 'required',
                'resultados' => 'required',
                'responsable' => 'required',
                'documento' => 'required',
                'tipo_empleado' => 'required',
                'descripcion_tipo_empleado' => 'required',
                'pais' => 'required',
                'inst_ent_nacs' => 'required',
                'movilidad' => 'required',
            ]);
        } else {
            $request->validate([
                'tipo' => 'required',
                'descripcion_tipo' => 'required',
                'resultados' => 'required',
                'responsable' => 'required',
                'documento' => 'required',
                'tipo_empleado' => 'required',
                'descripcion_tipo_empleado' => 'required',
                'pais' => 'required',
                'inst_ent_ints' => 'required',
                'movilidad' => 'required',
            ]);
        }

        $actividad->tipo = $request->tipo;
        $actividad->descripcion_tipo = $request->descripcion_tipo;
        $actividad->resultados = $request->resultados;
        $actividad->responsable = $request->responsable;
        $actividad->documento = $request->documento;
        $actividad->tipo_empleado = $request->tipo_empleado;
        $actividad->descripcion_tipo_empleado = $request->descripcion_tipo_empleado;
        $actividad->pais = $request->pais;
        if ($movilidad->nac_ext == 0) $actividad->inst_ent_nacs = $request->inst_ent_nacs;
        else $actividad->inst_ent_ints = $request->inst_ent_ints;
        $actividad->movilidad = $request->movilidad;

        $actividad->save();

        if ($movilidad->nac_ext == 0) return redirect()->route('movilidades_nac.index')->with('success', 'Actividad editada correctamente!');
        else return redirect()->route('movilidades_int.index')->with('success', 'Actividad editada correctamente!');
    }

    public function download($file)
    {
        return response()->download(public_path('files/actividades/' . $file));
    }

    public function destroy($act_id)
    {
        $actividad = Actividad::findOrFail($act_id);
        $movilidad = Movilidad::findOrFail($actividad->movilidad);
        $actividad->delete();
        
        if ($movilidad->nac_ext == 0) return redirect()->route('movilidades_nac.index')->with('success', 'Actividad eliminada correctamente!');
        else return redirect()->route('movilidades_int.index')->with('success', 'Actividad eliminada correctamente!');
    }
}
