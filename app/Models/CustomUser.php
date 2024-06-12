<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;

class CustomUser implements Authenticatable
{
    public $id;
    public $name;
    public $rol_id;

    public function __construct($id, $name, $rol_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->rol_id = $rol_id;
    }

    // Métodos requeridos por la interfaz Authenticatable

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return null; // No se utiliza en este caso
    }

    public function getRememberToken()
    {
        return null; // No se utiliza en este caso
    }

    public function setRememberToken($value)
    {
        // No se utiliza en este caso
    }

    public function getRememberTokenName()
    {
        return null; // No se utiliza en este caso
    }
}
