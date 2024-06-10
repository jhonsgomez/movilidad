<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $users = DB::table('users')
            ->join('roles', 'users.rol_id', '=', 'roles.id')
            ->select('users.*', 'roles.rol_codigo')
            ->where([
                ['users.id', '!=', 1],
                ['users.estado', '=', 1]
            ])->get();
        // dd($users);
        return view('users.index', compact('users'));
    }


    public function create()
    {
        $roles = DB::table('roles')->where([
            ['rol_name', '!=', 'Super Administrador'],
            ['estado', '=', 1]
        ])->get();
        return view('users.create', compact('roles'));
    }


    public function store(Request $request, User $user)
    {
        $request->validate([
            'documento' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'rol' => 'required'
        ]);

        $user->documento = $request->post("documento");
        $user->first_name = $request->post('first_name');
        $user->second_name = $request->post('second_name');
        $user->last_name = $request->post('last_name');
        $user->email = $request->post('email');
        $user->password = $request->post('password');
        $user->rol_id = $request->post('rol');

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario registrado correctamente!');
    }


    public function edit($id)
    {
        $user = User::find($id);
        $roles = DB::table('roles')->where([
            ['rol_name', '!=', 'Super Administrador'],
            ['estado', '=', 1]
        ])->get();
        return view('users.edit', compact(['user', 'roles']));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'documento' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'rol' => 'required'
        ]);

        $user = User::findOrFail($id);

        $user->documento = $request->documento;
        $user->first_name = $request->first_name;
        $user->second_name = $request->second_name;
        $user->last_name = $request->last_name;
        $user->rol_id = $request->rol;

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario editado correctamente');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->estado = 0;
        $user->save();
        return redirect('/users')->with('success', 'Usuario eliminado correctamente!');
    }

    public function editpass($id)
    {
        $user = User::findOrFail($id);
        return view('users.editpass', compact('user'));
    }

    public function updatepass(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->password = $request->password;

        $user->save();

        return redirect('/users')->with('success', 'Constraseña actualizada correctamente!');
    }
}
