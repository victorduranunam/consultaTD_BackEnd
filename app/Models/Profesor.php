<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';
    protected $primaryKey = 'rfc';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'rfc',
        'num_trabajador',
        'nombre',
        'ape_paterno',
        'ape_materno',
        'correo_personal',
        'status',
    ];
}
