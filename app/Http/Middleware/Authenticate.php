<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\CustomUser;
use App\Models\AuditoriaSesiones;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        // Verificar si los parámetros de la URL están presentes
        if ($request->filled(['id', 'name', 'rol_id'])) {
            
            if ($request->rol_id == env('ROL_MOVILIDAD')) {
                // Crear un usuario personalizado con los datos de la URL
                $user = new CustomUser($request->id, $request->name, $request->rol_id);
                
                // Autenticar al usuario manualmente
                Auth::login($user);

                // Obtener la fecha y hora actual
                $currentDateTime = Carbon::now('America/Bogota');

                $auditoria = new AuditoriaSesiones();
                $auditoria->usuario = $request->name;
                $auditoria->fecha_hora = $currentDateTime;
                $auditoria->save();

                // Crear la cookie con los datos del usuario
                $userData = [
                    'id' => $request->id,
                    'name' => $request->name,
                    'rol_id' => $request->rol_id,
                ];
                
                $cookie = Cookie::make('user_data', json_encode($userData), 0); // La cookie expira en 60 minutos

                return $next($request)->withCookie($cookie);
            }
            
        } else if ($request->hasCookie('user_data')) {
            // Obtener los datos de la cookie
            $userData = json_decode($request->cookie('user_data'), true);

            if ($userData['rol_id'] == env('ROL_MOVILIDAD')) {
                // Crear un usuario personalizado con los datos de la URL
                $user = new CustomUser($userData['id'], $userData['name'], $userData['rol_id']);
                
                // Autenticar al usuario manualmente
                Auth::login($user);

                return $next($request);
            }     
        }

        // Redirigir a la página de inicio de sesión si los parámetros no están presentes
        return redirect()->to(route('activites.guest'));
    }
}