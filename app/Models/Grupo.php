<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    protected $primaryKey = 'id_grupo';
    public $timestamps = false;

    protected $fillable = [
        'clave_asignatura',
        'rfc',
        'numero_grupo',
        'modalidad',
        'estatus_grupo',
        'alumnos_inscritos',
    ];
}
