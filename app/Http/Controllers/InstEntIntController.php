<?php

namespace App\Http\Controllers;

use App\Exports\InstEntIntExport;
use App\Models\InstEntInt;
use Illuminate\Http\Request;

class InstEntIntController extends Controller
{
    // Internacional
    public function index(Request $request)
    {
        $instInts = InstEntInt::where('estado', 1)->get();
        return view('instituciones.indexint', compact('instInts'));
    }


    public function create(Request $request)
    {
        return view('instituciones.createint');
    }


    public function store(Request $request)
    {
        $request->validate([
            'instentnameInt' => 'required',
            'inst_paisInt' => 'required',
            'ints_cityInt' => 'required',
            'representante' => 'required',
            'int_emailInt' => 'required|email',
        ]);

        $instentInt = new InstEntInt();
        $instentInt->nombre = $request->post('instentnameInt');
        $instentInt->pais = $request->post('inst_paisInt');
        $instentInt->ciudad = $request->post('ints_cityInt');
        $instentInt->nit = $request->post('ints_nitInt');
        $instentInt->representante = $request->post('representante');
        $instentInt->telefono = $request->post('ints_telefonoInt');
        $instentInt->email = $request->post('int_emailInt');
        $instentInt->user_id = auth()->user()->id;
        $instentInt->estado = 1;

        $instentInt->save();

        return redirect()->route('login.activites')
            ->with('success', 'Institución/Entidad creada correctamente!');
    }


    public function edit($id)
    {
        $instInt = InstEntInt::find($id);
        return view('instituciones.editint', compact('instInt'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'instentnameInt' => 'required',
            'inst_paisInt' => 'required',
            'ints_cityInt' => 'required',
            'representante' => 'required',
            'int_emailInt' => 'required|email',
        ]);

        $inst = InstEntInt::find($id);
        $inst->nombre = $request->instentnameInt;
        $inst->pais = $request->inst_paisInt;
        $inst->ciudad = $request->ints_cityInt;
        $inst->nit = $request->ints_nitInt;
        $inst->representante = $request->representante;
        $inst->telefono = $request->ints_telefonoInt;
        $inst->email = $request->int_emailInt;
        $inst->save();

        return redirect('/activities/cons_instituciones_int')
            ->with('success', 'Institución/Entidad actualizada correctamente!');
    }


    public function destroy($id)
    {
        $inst = InstEntInt::findOrFail($id);
        $inst->estado = 0;
        $inst->save();
        return redirect('/activities/cons_instituciones_int')
            ->with('success', 'Institución/Entidad con código ' . $inst->id . ' eliminada correctamente!');
    }

    public function exporting(Request $request)
    {
        $from = $request->input('instInt_initialDate');
        $to = $request->input('instInt_finalDate');
        $file_name = 'UTS - Instituciones Internacionales.xlsx';

        if ($from == Null && $to == Null) {
            return (new InstEntIntExport)
                ->forDate("0001-01-01", "9999-12-31")
                ->download($file_name);
        } elseif ($from != "" && $to == "") {
            return (new InstEntIntExport)
                ->forDate($from, $from)
                ->download($file_name);
        } elseif ($from != "" && $to != "") {
            return (new InstEntIntExport)
                ->forDate($from, $to)
                ->download($file_name);
        }
    }
}
