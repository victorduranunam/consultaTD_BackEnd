<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoAlumno extends Model
{
    protected $table = 'grupos_alumnos';
    protected $primaryKey = 'id_grupos_alumnos';
    public $timestamps = false; // Si no tienes campos created_at y updated_at
    protected $fillable = [
        'clave_asignatura',
        'rfc',
        'numero_grupo',
        'numero_cuenta',
    ];
}
