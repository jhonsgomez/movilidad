<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaSesiones extends Model
{
    use HasFactory;
    protected $table = 'auditoria_sesiones';
    public $timestamps = false;

    protected $fillable = [
        'usuario',
        'fecha_hora'
    ];
}
