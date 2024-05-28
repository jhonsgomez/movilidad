<?php

namespace App\Http\Controllers;

use App\Exports\MovilidadNacSalExport;
use App\Models\InstEntNac;
use App\Models\MovilidadNacSal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovilidadNacSalController extends Controller
{
    public function index()
    {
        $movnaent = DB::table('movilidad_nac_sals')
            ->join('inst_ent_nacs', 'movilidad_nac_sals.instEnt_id', '=', 'inst_ent_nacs.id')
            ->select('movilidad_nac_sals.*', 'inst_ent_nacs.nombre')->where('movilidad_nac_sals.estado', '=', 1)->get();
        return view('movilidades.saliente.indexnac', compact('movnaent'));
    }


    public function create()
    {
        $instEnt =  InstEntNac::where('estado', 1)->get();
        return view('movilidades.saliente.createnac', compact('instEnt'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'mns_adminstudoc' => 'required',
            'mns_instent' => 'required',
            'mns_activo' => 'required',
            'mns_fecha' => 'required',
            'mns_vigencia' => 'required',
        ]);

        $mov = new MovilidadNacSal();
        $mov->tipoPersona = $request->post('mns_adminstudoc');
        $mov->colInd = $request->post('mns_colInd');
        $mov->fullname = $request->post('mns_fullname');
        $mov->cantidad = $request->post('mns_cantidad');
        $mov->titulosOb = $request->post('mns_titulos');
        $mov->activo = $request->post('mns_activo');
        $mov->fecha = $request->post('mns_fecha');
        $mov->vigencia = $request->post('mns_vigencia');
        $mov->sedeReg = $request->post('mns_sedereg');
        $mov->objeto = $request->post('mns_objeto');
        $mov->resultado = $request->post('mns_result');
        $mov->instEnt_id = $request->post('mns_instent');
        $mov->user_id = auth()->user()->id;

        $mov->save();

        return redirect()->route('login.activites')
            ->with('success', 'Movilidad creada correctamente!');
    }


    public function show($id)
    {
        //
    }


    public function edit($mov_id)
    {
        $instEnt = InstEntNac::where('estado', 1)->get();
        $movnacsal = MovilidadNacSal::findOrFail($mov_id);
        return view('Movilidades/saliente.editnac', compact(['instEnt', 'movnacsal']));
    }


    public function update(Request $request, $mov_id)
    {
        $request->validate([
            'mns_adminstudoc' => 'required',
            'mns_instent' => 'required',
            'mns_activo' => 'required',
            'mns_fecha' => 'required',
            'mns_vigencia' => 'required',
        ]);

        $mov = MovilidadNacSal::findOrFail($mov_id);
        $mov->tipoPersona = $request->post('mns_adminstudoc');
        $mov->colInd = $request->post('mns_colInd');
        $mov->fullname = $request->post('mns_fullname');
        $mov->cantidad = $request->post('mns_cantidad');
        $mov->titulosOb = $request->post('mns_titulos');
        $mov->activo = $request->post('mns_activo');
        $mov->fecha = $request->post('mns_fecha');
        $mov->vigencia = $request->post('mns_vigencia');
        $mov->sedeReg = $request->post('mns_sedereg');
        $mov->objeto = $request->post('mns_objeto');
        $mov->resultado = $request->post('mns_result');

        $mov->save();

        return redirect('/activities/cons_movilidad_nac/saliente')
            ->with('success', 'Movilidad editada correctamente!');
    }


    public function destroy($mov_id)
    {
        $mov = MovilidadNacSal::findOrFail($mov_id);
        $mov->estado = 0;
        $mov->save();
        return redirect('/activities/cons_movilidad_nac/saliente')
            ->with('success', 'Movilidad/Entidad con código ' . $mov_id . ' 
        eliminada correctamente!');
    }

    public function exporting(Request $request)
    {
        $from = $request->input('mns_initialDate');
        $to = $request->input('mns_finalDate');
        $file_name = 'movilidad_nac_sal_' . date('d-m-Y', time()) . '.xls';

        if ($from == Null && $to == Null) {
            return (new MovilidadNacSalExport)
                ->forDate("0001-01-01", "9999-12-31")
                ->download($file_name);
        } elseif ($from != "" && $to == "") {
            return (new MovilidadNacSalExport)
                ->forDate($from, $from)
                ->download($file_name);
        } elseif ($from != "" && $to != "") {
            return (new MovilidadNacSalExport)
                ->forDate($from, $to)
                ->download($file_name);
        }
    }
}
