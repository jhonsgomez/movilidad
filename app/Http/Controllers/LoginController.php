<?php

namespace App\Http\Controllers;

use App\Models\ConvenioInt;
use App\Models\ConvenioNac;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function show()
    {
        if (auth()->user()) return redirect()->to('/activities');
        else return view('auth.login');
    }

    public function show_guest()
    {
        return view('activities.activities_guest');
    }

    public function consult()
    {
        if (auth()->attempt(request(['email', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'Email o contraseñas incorrectos, intente de nuevo',
            ]);
        } else {
            return redirect()->to('/activities');
        }
    }

    public function destroy()
    {
        auth()->logout();
        return redirect()->to('/');
    }

    public function activity_view(Request $request)
    {
        // Redireccionamiento para ORI y DIE
        $actions = $request->input('actions');
        $about_what = $request->input('about_what');
        $nacoInt = $request->input('nacoInt');
        $entSal = $request->input('entSal');
        $type_convenio = $request->input('type_convenio');

        $request->session()->put('type_convenio', $request->input('type_convenio'));


        if ($about_what != ""  || $actions != "") {
            if ($actions == "registrar" && $about_what == "convenios") {
                if (auth()->user()->rol_id == '2') {
                    return redirect('/activities/registro_convenios_nac');
                } else if (auth()->user()->rol_id == '3') {
                    return redirect('/activities/registro_convenios_int');
                } else if (auth()->user()->rol_id == '6') {
                    if ($nacoInt == 'internacional') {
                        return redirect('/activities/registro_convenios_int');
                    } else if ($nacoInt == 'nacional') {
                        return redirect('/activities/registro_convenios_nac');
                    }
                }
            } else if ($actions == "registrar" && $about_what == "instituciones") {
                if (auth()->user()->rol_id == '2') {
                    return redirect('/activities/registro_instituciones_nac');
                } else if (auth()->user()->rol_id == '3') {
                    return redirect('/activities/registro_instituciones_int');
                } else if (auth()->user()->rol_id == '6') {
                    if ($nacoInt == 'internacional') {
                        return redirect('/activities/registro_instituciones_int');
                    } else if ($nacoInt == 'nacional') {
                        return redirect('/activities/registro_instituciones_nac');
                    }
                }
            } else if ($actions == "consultar" && $about_what == "instituciones" && $nacoInt == "internacional") {
                return redirect('/activities/cons_instituciones_int');
            } else if ($actions == "consultar" && $about_what == "instituciones" && $nacoInt == "nacional") {
                return redirect('/activities/cons_instituciones_nac');
            } else if ($actions == "consultar" && $about_what == "convenios" && $nacoInt == "internacional") {
                return redirect()->route('convenios.show_int');
            } else if ($actions == "consultar" && $about_what == "convenios" && $nacoInt == "nacional") {
                return redirect()->route('convenios.show_nac');



            } else if ($actions == "consultar" && $about_what == "movilidad" && $nacoInt == "nacional") {
                return redirect('/activities/cons_movilidad_nac');
            } else if ($actions == "consultar" && $about_what == "movilidad" && $nacoInt == "internacional") {
                return redirect('/activities/cons_movilidad_int');
            } else if ($actions == "registrar" && $about_what == "movilidad" && $nacoInt == "nacional") {
                return redirect('/activities/create_movilidad_nac');
            } else if ($actions == "registrar" && $about_what == "movilidad" && $nacoInt == "internacional") {
                return redirect('/activities/create_movilidad_int');
            }

            /* 
                ($actions == "registrar" && $about_what == "movilidad" && $nacoInt == "nacional" && $entSal == "entrante") {
                return redirect('/activities/registro_movilidad_nac/entrante');
            } else if ($actions == "registrar" && $about_what == "movilidad" && $nacoInt == "nacional" && $entSal == "saliente") {
                return redirect('/activities/registro_movilidad_nac/saliente');
            } else if ($actions == "registrar" && $about_what == "movilidad" && $nacoInt == "internacional" && $entSal == "saliente") {
                return redirect('/activities/registro_movilidad_int/saliente');
            } else if ($actions == "registrar" && $about_what == "movilidad" && $nacoInt == "internacional" && $entSal == "entrante") {
                return redirect('/activities/registro_movilidad_int/entrante');
                //rutas para consulta de movilidad
            } else if ($actions == "consultar" && $about_what == "movilidad" && $nacoInt == "internacional" && $entSal == "entrante") {
                return redirect('/activities/cons_movilidad_int/entrante');
            } else if ($actions == "consultar" && $about_what == "movilidad" && $nacoInt == "nacional" && $entSal == "entrante") {
                return redirect('/activities/cons_movilidad_nac/entrante');
            } else if ($actions == "consultar" && $about_what == "movilidad" && $nacoInt == "internacional" && $entSal == "saliente") {
                return redirect('/activities/cons_movilidad_int/saliente');
            } else if ($actions == "consultar" && $about_what == "movilidad" && $nacoInt == "nacional" && $entSal == "saliente") {
                return redirect('/activities/cons_movilidad_nac/saliente');
            }*/
        }
            
        // Redireccionamiento para Coordinaciones u otras dependencias
        $c_o_actions = $request->input('c_o_actions');
        $c_o_about_what = $request->input('c_o_about_what');
        $c_o_nacoInt = $request->input('c_o_nacoInt');
        $c_o_entSal = $request->input('c_o_entSal');

        if ($c_o_actions != "" && $c_o_about_what != "") {
            if ($c_o_actions == "registrar" && $c_o_about_what == "movilidad" && $c_o_nacoInt == "internacional" && $c_o_entSal == "entrante") {
                return redirect('/activities/registro_movilidad_int/entrante');
            } else if ($c_o_actions == "registrar" && $c_o_about_what == "movilidad" && $c_o_nacoInt == "internacional" && $c_o_entSal == "saliente") {
                return redirect('/activities/registro_movilidad_int/saliente');
            } else if ($c_o_actions == "registrar" && $c_o_about_what == "movilidad" && $c_o_nacoInt == "nacional" && $c_o_entSal == "entrante") {
                return redirect('/activities/registro_movilidad_nac/entrante');
            } else if ($c_o_actions == "registrar" && $c_o_about_what == "movilidad" && $c_o_nacoInt == "nacional" && $c_o_entSal == "saliente") {
                return redirect('/activities/registro_movilidad_nac/saliente');
            } else if ($c_o_actions == "consultar" &&  $c_o_about_what == "convenio" && $c_o_nacoInt == "internacional") {
                return redirect('/activities/cons_convenios_int');
            } else if ($c_o_actions == "consultar" &&  $c_o_about_what == "convenio" && $c_o_nacoInt == "nacional") {
                return redirect('/activities/cons_convenios_nac');
            } else if ($c_o_actions == "consultar" &&  $c_o_about_what == "institucion" && $c_o_nacoInt == "internacional") {
                return redirect('/activities/cons_instituciones_int');
            } else if ($c_o_actions == "consultar" &&  $c_o_about_what == "institucion" && $c_o_nacoInt == "nacional") {
                return redirect('/activities/cons_instituciones_nac');
            } else if ($c_o_actions == "consultar" && $c_o_about_what == "movilidad" && $c_o_nacoInt == "internacional" && $c_o_entSal == "entrante") {
                return redirect('/activities/cons_movilidad_int/entrante');
            } else if ($c_o_actions == "consultar" && $c_o_about_what == "movilidad" && $c_o_nacoInt == "nacional" && $c_o_entSal == "entrante") {
                return redirect('/activities/cons_movilidad_nac/entrante');
            } else if ($c_o_actions == "consultar" && $c_o_about_what == "movilidad" && $c_o_nacoInt == "internacional" && $c_o_entSal == "saliente") {
                return redirect('/activities/cons_movilidad_int/saliente');
            } else if ($c_o_actions == "consultar" && $c_o_about_what == "movilidad" && $c_o_nacoInt == "nacional" && $c_o_entSal == "saliente") {
                return redirect('/activities/cons_movilidad_nac/saliente');
            }
        }
        return view('activities.select_activities');
    }

    public function activity_guest(Request $request)
    {
        $guest_Conv = $request->input('guest_Conv');
        $guest_type = $request->input('guest_type');

        if ($guest_Conv != "" && $guest_type != "") {
            if ($guest_Conv == "nacional") {
                $convNacs = DB::table('convenio_nacs')
                    ->join('inst_ent_nacs', 'convenio_nacs.instEntNac_id', '=', 'inst_ent_nacs.id')
                    ->select('convenio_nacs.*', 'inst_ent_nacs.nombre', 'inst_ent_nacs.ciudad')
                    ->where('convenio_nacs.estado', '=', 1)
                    ->where('convenio_nacs.tipo', '=', $guest_type)
                    ->get();
                return view('convenios_act.indexnac', compact('convNacs'));
            } elseif ($guest_Conv == "internacional") {
                $convInts = DB::table('convenio_ints')
                    ->join('inst_ent_ints', 'convenio_ints.instEntInt_id', '=', 'inst_ent_ints.id')
                    ->select('convenio_ints.*', 'inst_ent_ints.nombre', 'inst_ent_ints.pais')
                    ->where('convenio_ints.estado', '=', 1)
                    ->where('convenio_ints.tipo', '=', $guest_type)
                    ->get();
                return view('convenios_act.indexint', compact('convInts'));
            }
        }
        return redirect('/activities_guest');
    }
}
