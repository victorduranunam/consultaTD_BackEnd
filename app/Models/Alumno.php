<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';
    protected $primaryKey = 'numero_cuenta';
    public $incrementing = false; // Porque la PK no es un entero autoincremental
    public $timestamps = false; // Si no tienes campos created_at y updated_at
    public $keyType = 'string';

    protected $fillable = [
        'numero_cuenta',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo_personal',
        'avance',
        'semestre_ingreso',
        'carrera',
        'promedio',
        'estatus',
        'plan_estudios',
        'modo_inscripcion'
    ];
}



