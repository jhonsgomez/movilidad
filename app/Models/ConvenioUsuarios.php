<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvenioUsuarios extends Model
{
    use HasFactory;
    protected $table = 'convenio_usuarios';
    protected $fillable = [
        'documento',
        'nombre',
        'programa_academico',
        'periodo_academico',
        'correo_institucional',
        'numero_telefono',
        'fecha_inicio',
        'fecha_terminacion',
        'duracion',
        'supervisor',
        'nac_int',
        'convenio_id'
    ];
}
