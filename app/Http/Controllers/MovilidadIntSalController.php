<?php

namespace App\Http\Controllers;

use App\Exports\MovilidadIntSalExport;
use App\Models\InstitucionEntidadInt;
use App\Models\MovilidadIntSal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovilidadIntSalController extends Controller
{

    public function index()
    {
        $movintsal = DB::table('movilidad_int_sals')
            ->join('institucion_entidad_ints', 'movilidad_int_sals.instEnt_id', '=', 'institucion_entidad_ints.id')
            ->select('movilidad_int_sals.*', 'institucion_entidad_ints.nombre')->where('movilidad_int_sals.estado', '=', 1)->get();
        return view('movilidades.saliente.indexint', compact('movintsal'));
    }


    public function create()
    {
        $instEnt = InstitucionEntidadInt::where('estado', 1)->get();
        return view('movilidades.saliente.createint', compact('instEnt'));
    }


    public function store(Request $request, MovilidadIntSal $movsal)
    {
        $request->validate([
            'mis_adminstudoc' => 'required',
            'mis_instent' => 'required',
            'mis_activo' => 'required',
            'mis_fecha' => 'required',
            'mis_vigencia' => 'required',
        ]);

        $movsal->tipoPersona = $request->post('mis_adminstudoc');
        $movsal->colInd = $request->post('mis_colInd');
        $movsal->fullname = $request->post('mis_fullname');
        $movsal->cantidad = $request->post('mis_cantidad');
        $movsal->titulosOb = $request->post('mis_titulos');
        $movsal->activo = $request->post('mis_activo');
        $movsal->fecha = $request->post('mis_fecha');
        $movsal->vigencia = $request->post('mis_vigencia');
        $movsal->sedeReg = $request->post('mis_sedereg');
        $movsal->objeto = $request->post('mis_objeto');
        $movsal->resultado = $request->post('mis_result');
        $movsal->instEnt_id = $request->post('mis_instent');
        $movsal->user_id = auth()->user()->id;

        $movsal->save();

        return redirect()->route('login.activites')
            ->with('success', 'Movilidad creada correctamente!');
    }


    public function edit($mov_id)
    {
        $instEnt = InstitucionEntidadInt::where('estado', 1)->get();
        $movintsal = MovilidadIntSal::findOrFail($mov_id);
        return view('Movilidades/saliente.editint', compact(['instEnt', 'movintsal']));
    }


    public function update(Request $request, $mov_id)
    {
        $request->validate([
            'mis_adminstudoc' => 'required',
            'mis_instent' => 'required',
            'mis_activo' => 'required',
            'mis_fecha' => 'required',
            'mis_vigencia' => 'required',
        ]);

        $mov = MovilidadIntSal::findOrFail($mov_id);
        $mov->tipoPersona = $request->post('mis_adminstudoc');
        $mov->colInd = $request->post('mis_colInd');
        $mov->fullname = $request->post('mis_fullname');
        $mov->cantidad = $request->post('mis_cantidad');
        $mov->titulosOb = $request->post('mis_titulos');
        $mov->activo = $request->post('mis_activo');
        $mov->fecha = $request->post('mis_fecha');
        $mov->vigencia = $request->post('mis_vigencia');
        $mov->sedeReg = $request->post('mis_sedereg');
        $mov->objeto = $request->post('mis_objeto');
        $mov->resultado = $request->post('mis_result');



        $mov->save();

        return redirect('/activities/cons_movilidad_int/saliente')
            ->with('success', 'Movilidad editada correctamente!');
    }


    public function destroy($mov_id)
    {
        $mov = MovilidadIntSal::findOrFail($mov_id);
        $mov->estado = 0;
        $mov->save();
        return redirect('/activities/cons_movilidad_int/saliente')
            ->with('success', 'Institución/Entidad con código ' . $mov_id . ' 
        eliminada correctamente!');
    }

    public function exporting(Request $request)
    {
        $from = $request->input('mis_initialDate');
        $to = $request->input('mis_finalDate');
        $file_name = 'movilidad_int_sal_' . date('d-m-Y', time()) . '.xls';

        if ($from == Null && $to == Null) {
            return (new MovilidadIntSalExport)
                ->forDate("0001-01-01", "9999-12-31")
                ->download($file_name);
        } elseif ($from != "" && $to == "") {
            return (new MovilidadIntSalExport)
                ->forDate($from, $from)
                ->download($file_name);
        } elseif ($from != "" && $to != "") {
            return (new MovilidadIntSalExport)
                ->forDate($from, $to)
                ->download($file_name);
        }
    }
}
