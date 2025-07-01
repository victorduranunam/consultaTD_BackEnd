<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';

    public $incrementing = false;   // id asignado manualmente
    protected $keyType = 'int';     // o 'bigint' si usas bigint en BD

    protected $fillable = [
        'id',    // para asignarlo manualmente
        'name',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public function usuarios()
    {
        return $this->hasMany(UsuarioApi::class, 'role_id');
    }
}
