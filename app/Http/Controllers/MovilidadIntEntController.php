<?php

namespace App\Http\Controllers;

use App\Exports\MovilidadIntEntExport;
use App\Models\InstitucionEntidadInt;
use App\Models\InstEntNac;
use App\Models\MovilidadIntEnt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use function PHPSTORM_META\map;

class MovilidadIntEntController extends Controller
{

    public function index()
    {
        $moventr = DB::table('movilidad_int_ents')
            ->join('institucion_entidad_ints', 'movilidad_int_ents.instEnt_id', '=', 'institucion_entidad_ints.id')
            ->select('movilidad_int_ents.*', 'institucion_entidad_ints.nombre')->where('movilidad_int_ents.estado', '=', 1)->get();
        return view('movilidades.entrante.indexmov', compact('moventr'));
    }


    public function create()
    {
        $instEnt = InstitucionEntidadInt::where('estado', 1)->get();
        return view('movilidades.entrante.createint', compact('instEnt'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'mie_adminstudoc' => 'required',
            'mie_instent' => 'required',
            'mie_activo' => 'required',
            'mie_fecha' => 'required',
            'mie_vigencia' => 'required',
        ]);

        $mov = new MovilidadIntEnt();
        $mov->tipoPersona = $request->post('mie_adminstudoc');
        $mov->colInd = $request->post('mie_colInd');
        $mov->fullname = $request->post('mie_fullname');
        $mov->cantidad = $request->post('mie_cantidad');
        $mov->titulosOb = $request->post('mie_titulos');
        $mov->activo = $request->post('mie_activo');
        $mov->fecha = $request->post('mie_fecha');
        $mov->vigencia = $request->post('mie_vigencia');
        $mov->sedeReg = $request->post('mie_sedereg');
        $mov->objeto = $request->post('mie_objeto');
        $mov->resultado = $request->post('mie_result');
        $mov->instEnt_id = $request->post('mie_instent');
        $mov->user_id = auth()->user()->id;


        $mov->save();

        return redirect()->route('login.activites')
            ->with('success', 'Movilidad creada correctamente!');
    }

    public function show($id)
    {
        return redirect('movilidades.entrante.indexint');
    }


    public function edit($mov_id)
    {
        $instEnt = InstitucionEntidadInt::where('estado', 1)->get();
        $moventr = MovilidadIntEnt::findOrFail($mov_id);
        return view('movilidades.entrante.editint', compact(['instEnt', 'moventr']));
    }


    public function update(Request $request, $mov_id)
    {
        $request->validate([
            'mie_adminstudoc' => 'required',
            'mie_instent' => 'required',
            'mie_activo' => 'required',
            'mie_fecha' => 'required',
            'mie_vigencia' => 'required',
        ]);

        $mov = MovilidadIntEnt::findOrFail($mov_id);
        $mov->tipoPersona = $request->mie_adminstudoc;
        $mov->colInd = $request->mie_colInd;
        $mov->fullname = $request->mie_fullname;
        $mov->cantidad = $request->mie_cantidad;
        $mov->titulosOb = $request->mie_titulos;
        $mov->activo = $request->mie_activo;
        $mov->fecha = $request->mie_fecha;
        $mov->vigencia = $request->mie_vigencia;
        $mov->sedeReg = $request->mie_sedereg;
        $mov->objeto = $request->mie_objeto;
        $mov->resultado = $request->mie_result;
        $mov->instEnt_id = $request->mie_instent;
        $mov->user_id = auth()->user()->id;


        $mov->save();

        return redirect()->route('movilidades_ent_int.index')
            ->with('success', 'Movilidad editada correctamente!');
    }

    public function destroy($mov_id)
    {
        $mov = MovilidadIntEnt::findOrFail($mov_id);
        $mov->estado = 0;
        $mov->save();
        return redirect('/activities/cons_movilidad_int/entrante')
            ->with('success', 'Institución/Entidad con código ' . $mov_id . ' 
        eliminada correctamente!');
    }

    public function exporting(Request $request)
    {
        $from = $request->input('mie_initialDate');
        $to = $request->input('mie_finalDate');
        $file_name = 'movilidad_int_ent_' . date('d-m-Y', time()) . '.xls';

        if ($from == Null && $to == Null) {
            return (new MovilidadIntEntExport)
                ->forDate("0001-01-01", "9999-12-31")
                ->download($file_name);
        } elseif ($from != "" && $to == "") {
            return (new MovilidadIntEntExport)
                ->forDate($from, $from)
                ->download($file_name);
        } elseif ($from != "" && $to != "") {
            return (new MovilidadIntEntExport)
                ->forDate($from, $to)
                ->download($file_name);
        }
    }
}
