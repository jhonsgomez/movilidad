<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistentesActividades extends Model
{
    use HasFactory;
    protected $table = 'actividades_asistentes';
    protected $fillable = [
        'documento',
        'nombre',
        'programa_academico',
        'periodo_academico',
        'correo_institucional',
        'numero_telefono',
        'actividad_id'
    ];
    public $timestamps = false;
}
