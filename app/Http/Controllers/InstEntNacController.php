<?php

namespace App\Http\Controllers;

use App\Exports\InstEntNacExport;
use App\Models\InstEntNac;
use Illuminate\Http\Request;

class InstEntNacController extends Controller
{
    public function index(Request $request)
    {
        $intNacs = InstEntNac::where('estado', 1)->get();
        return view('instituciones.indexnac', compact('intNacs'));
    }

    public function create(Request $request)
    {
        return view('instituciones.createnac');
    }


    public function store(Request $request)
    {
        $request->validate([
            'instentnameNac' => 'required',
            'dtpcitymunNac' => 'required',
            'emailNac' => 'required',
            'representante' => 'required',
            'inst_docsoporteNac' => 'required|array',
        ]);

        // Guardar multiples archivos
        // Para acceder a estos se debe utilizar explode (método inverso al implode)
        $files = [];
        if ($request->hasFile('inst_docsoporteNac')) {
            foreach ($request->file('inst_docsoporteNac') as $file) {
                $name = time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('files/institucionesNac'), $name);
                $files[] = $name;
            }
        }

        $instentNact = new InstEntNac();
        $instentNact->nombre = $request->post('instentnameNac');
        $instentNact->ciudad = $request->post('dtpcitymunNac');
        $instentNact->nit = $request->post('nitNac');
        $instentNact->representante = $request->post('representante');
        $instentNact->telefono = $request->post('telefonoNac');
        $instentNact->email = $request->post('emailNac');
        $instentNact->docSoportes = implode(",", $files);
        $instentNact->user_id = auth()->user()->id;
        $instentNact->estado = 1;

        $instentNact->save();

        return redirect()->route('login.activites')->with('success', 'Institución/Entidad creada correctamente!');
    }


    public function download($file)
    {
        return response()->download(public_path('files/institucionesNac/' . $file));
    }


    public function edit($id)
    {
        $instNac = InstEntNac::find($id);
        return view('instituciones.editnac', compact('instNac'));
    }


    public function update(Request $request, $inst_id)
    {
        $request->validate([
            'instentnameNac' => 'required',
            'dtpcitymunNac' => 'required',
            'emailNac' => 'required',
            'representante' => 'required',
        ]);

        $inst = InstEntNac::find($inst_id);
        $inst->nombre = $request->instentnameNac;
        $inst->ciudad = $request->dtpcitymunNac;
        $inst->nit = $request->nitNac;
        $inst->representante = $request->representante;
        $inst->telefono = $request->telefonoNac;
        $inst->email = $request->emailNac;

        $inst->save();

        return redirect('/activities/cons_instituciones_nac')
            ->with('success', 'Institución/Entidad editada correctamente!');
    }


    public function destroy(Request $request, $id)
    {
        $inst = InstEntNac::findOrFail($id);
        $inst->estado = 0;
        $inst->save();
        return redirect('/activities/cons_instituciones_nac')
            ->with('success', 'Institución/Entidad con código ' . $inst->id . ' eliminada correctamente!');
    }

    public function exporting(Request $request)
    {
        $from = $request->input('instNac_initialDate');
        $to = $request->input('instNac_finalDate');
        $file_name = 'UTS - Instituciones Nacionales.xlsx';

        if ($from == Null && $to == Null) {
            return (new InstEntNacExport)
                ->forDate("0001-01-01", "9999-12-31")
                ->download($file_name);
        } elseif ($from != "" && $to == "") {
            return (new InstEntNacExport)
                ->forDate($from, $from)
                ->download($file_name);
        } elseif ($from != "" && $to != "") {
            return (new InstEntNacExport)
                ->forDate($from, $to)
                ->download($file_name);
        }
    }
}
