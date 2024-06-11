<?php

namespace App\Http\Controllers;

use App\Models\ConvenioNac;
use App\Models\ConvenioInt;

use App\Models\ConvenioUsuarios;
use App\Exports\ConvenioNacUsuariosExport;
use App\Exports\ConvenioIntUsuariosExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class ConvenioUsuariosController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'documento' => 'required',
            'nombre' => 'required',
            'programa_academico' => 'required',
            'periodo_academico' => 'required',
            'correo_institucional' => 'required',
            'numero_telefono' => 'required',
            'fecha_inicio' => 'required',
            'fecha_terminacion' => 'required',
            'duracion' => 'required',
            'type_duracion' => 'required',
            'nac_int' => 'required',
            'convenio_id' => 'required'
        ]);

        $usuario = new ConvenioUsuarios();

        $usuario->documento = $request->post('documento');
        $usuario->nombre = $request->post('nombre');
        $usuario->programa_academico = $request->post('programa_academico');
        $usuario->periodo_academico = $request->post('periodo_academico');
        $usuario->correo_institucional = $request->post('correo_institucional');
        $usuario->numero_telefono = $request->post('numero_telefono');
        $usuario->fecha_inicio = $request->post('fecha_inicio');
        $usuario->fecha_terminacion = $request->post('fecha_terminacion');
        $usuario->duracion = $request->post('duracion') . " " . $request->post('type_duracion');
        $usuario->supervisor = $request->post('supervisor');
        $usuario->nac_int = $request->post('nac_int');
        $usuario->convenio_id = $request->post('convenio_id');

        $usuario->save();

        $convenio;

        if ($request->post('nac_int') == 0) $convenio = ConvenioNac::findOrFail($request->post('convenio_id'));
        else $convenio = ConvenioInt::findOrFail($request->post('convenio_id'));
        
        $convenio->n_usuarios = $convenio->n_usuarios + 1;
        $convenio->save();

        if ($request->post('nac_int') == 0) {
            return redirect('/activities/cons_convenios_nac')
                ->with('success', 'Usuario agregado correctamente!');
        } else {
            return redirect('/activities/cons_convenios_int')
                ->with('success', 'Usuario agregado correctamente!');
        }  
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'documento' => 'required',
            'nombre' => 'required',
            'programa_academico' => 'required',
            'periodo_academico' => 'required',
            'correo_institucional' => 'required',
            'numero_telefono' => 'required',
            'fecha_inicio' => 'required',
            'fecha_terminacion' => 'required',
            'duracion' => 'required',
            'type_duracion' => 'required',
            'nac_int' => 'required',
            'convenio_id' => 'required'
        ]);

        $usuario = ConvenioUsuarios::findOrFail($request->post('id'));

        $usuario->documento = $request->post('documento');
        $usuario->nombre = $request->post('nombre');
        $usuario->programa_academico = $request->post('programa_academico');
        $usuario->periodo_academico = $request->post('periodo_academico');
        $usuario->correo_institucional = $request->post('correo_institucional');
        $usuario->numero_telefono = $request->post('numero_telefono');
        $usuario->fecha_inicio = $request->post('fecha_inicio');
        $usuario->fecha_terminacion = $request->post('fecha_terminacion');
        $usuario->duracion = $request->post('duracion') . " " . $request->post('type_duracion');
        $usuario->supervisor = $request->post('supervisor');
        $usuario->nac_int = $request->post('nac_int');
        $usuario->convenio_id = $request->post('convenio_id');

        $usuario->save();

        if ($usuario->nac_int == 0) {
            return redirect('/activities/cons_convenios_nac')
                ->with('success', 'Usuario editado correctamente!');
        } else {
            return redirect('/activities/cons_convenios_int')
                ->with('success', 'Usuario editado correctamente!');
        } 
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'nac_int' => 'required',
            'convenio_id' => 'required'
        ]);

        $usuario = ConvenioUsuarios::findOrFail($request->post('user_id'));
        $usuario->delete();

        $convenio;

        if ($request->post('nac_int') == 0) $convenio = ConvenioNac::findOrFail($request->post('convenio_id'));
        else $convenio = ConvenioInt::findOrFail($request->post('convenio_id'));
        
        $convenio->n_usuarios = $convenio->n_usuarios - 1;
        $convenio->save();

        if ($request->post('nac_int') == 0) {
            return redirect('/activities/cons_convenios_nac')
                ->with('success', 'Usuario eliminado correctamente!');
        } else {
            return redirect('/activities/cons_convenios_int')
                ->with('success', 'Usuario eliminado correctamente!');
        }
    }

    public function report_nacs(Request $request)
    {
        $request->validate([
            'convenio_id' => 'required'
        ]);

        $convenio_id = $request->post('convenio_id');

        return Excel::download(new ConvenioNacUsuariosExport($convenio_id), 'UTS - Reporte de Usuarios.xlsx');
    }

    public function report_ints(Request $request)
    {
        $request->validate([
            'convenio_id' => 'required'
        ]);

        $convenio_id = $request->post('convenio_id');

        return Excel::download(new ConvenioIntUsuariosExport($convenio_id), 'UTS - Reporte de Usuarios.xlsx');
    }

    public function report_all(Request $request)
    {
        return Excel::download(new ConvenioAllUsuariosExport(), 'UTS - Reporte de Usuarios.xlsx');
    }
}
