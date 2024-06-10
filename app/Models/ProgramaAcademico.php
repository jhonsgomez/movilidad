<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaAcademico extends Model
{
    use HasFactory;
    protected $table = 'actividades_asistentes';
    protected $fillable = [
        'nombre'
    ];
    public $timestamps = false;
}
