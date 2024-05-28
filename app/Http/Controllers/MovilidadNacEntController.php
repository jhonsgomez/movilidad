<?php

namespace App\Http\Controllers;

use App\Exports\MovilidadNacEntExport;
use App\Models\InstEntNac;
use App\Models\MovilidadNacEnt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovilidadNacEntController extends Controller
{

    public function index()
    {
        $movnaent = DB::table('movilidad_nac_ents')
            ->join('inst_ent_nacs', 'movilidad_nac_ents.instEnt_id', '=', 'inst_ent_nacs.id')
            ->select('movilidad_nac_ents.*', 'inst_ent_nacs.nombre')->where('movilidad_nac_ents.estado', '=', 1)->get();
        return view('movilidades.entrante.indexnac', compact('movnaent'));
    }


    public function create()
    {
        $instEnt =  InstEntNac::where('estado', 1)->get();
        return view('movilidades.entrante.createnac', compact('instEnt'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'mne_adminstudoc' => 'required',
            'mne_instent' => 'required',
            'mne_activo' => 'required',
            'mne_fecha' => 'required',
            'mne_vigencia' => 'required',
        ]);

        $mov = new MovilidadNacEnt();
        $mov->tipoPersona = $request->post('mne_adminstudoc');
        $mov->colInd = $request->post('mne_colInd');
        $mov->fullname = $request->post('mne_fullname');
        $mov->cantidad = $request->post('mne_cantidad');
        $mov->titulosOb = $request->post('mne_titulos');
        $mov->activo = $request->post('mne_activo');
        $mov->fecha = $request->post('mne_fecha');
        $mov->vigencia = $request->post('mne_vigencia');
        $mov->sedeReg = $request->post('mne_sedereg');
        $mov->objeto = $request->post('mne_objeto');
        $mov->resultado = $request->post('mne_result');
        $mov->instEnt_id = $request->post('mne_instent');
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
        $movnaent = MovilidadNacEnt::findOrFail($mov_id);
        return view('Movilidades/entrante.editnac', compact(['instEnt', 'movnaent']));
    }


    public function update(Request $request, $mov_id)
    {
        $request->validate([
            'mne_adminstudoc' => 'required',
            'mne_instent' => 'required',
            'mne_activo' => 'required',
            'mne_fecha' => 'required',
            'mne_vigencia' => 'required',
        ]);

        $mov = MovilidadNacEnt::findOrFail($mov_id);
        $mov->tipoPersona = $request->post('mne_adminstudoc');
        $mov->colInd = $request->post('mne_colInd');
        $mov->fullname = $request->post('mne_fullname');
        $mov->cantidad = $request->post('mne_cantidad');
        $mov->titulosOb = $request->post('mne_titulos');
        $mov->activo = $request->post('mne_activo');
        $mov->fecha = $request->post('mne_fecha');
        $mov->vigencia = $request->post('mne_vigencia');
        $mov->sedeReg = $request->post('mne_sedereg');
        $mov->objeto = $request->post('mne_objeto');
        $mov->resultado = $request->post('mne_result');
        $mov->save();
        return redirect('/activities/cons_movilidad_nac/entrante')
            ->with('success', 'Movilidad editada correctamente!');
    }


    public function destroy($mov_id)
    {
        $mov = MovilidadNacEnt::findOrFail($mov_id);
        $mov->estado = 0;
        $mov->save();
        return redirect('/activities/cons_movilidad_nac/entrante')
            ->with('success', 'Institución/Entidad con código ' . $mov_id . ' 
        eliminada correctamente!');
    }

    public function exporting(Request $request)
    {
        $from = $request->input('mne_initialDate');
        $to = $request->input('mne_finalDate');
        $file_name = 'movilidad_nac_ent_' . date('d-m-Y', time()) . '.xls';

        if ($from == Null && $to == Null) {
            return (new MovilidadNacEntExport)
                ->forDate("0001-01-01", "9999-12-31")
                ->download($file_name);
        } elseif ($from != "" && $to == "") {
            return (new MovilidadNacEntExport)
                ->forDate($from, $from)
                ->download($file_name);
        } elseif ($from != "" && $to != "") {
            return (new MovilidadNacEntExport)
                ->forDate($from, $to)
                ->download($file_name);
        }
    }
}
