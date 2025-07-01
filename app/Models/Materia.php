<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 'materias';
    protected $primaryKey = 'clave_asignatura';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'clave_asignatura',
        'nombre_asignatura',
        'plan_estudios',
        'division',
    ];
}
