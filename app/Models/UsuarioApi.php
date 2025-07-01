<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class UsuarioApi extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios_api';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'status',
        'role_id',
    ];


    protected $hidden = ['password'];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    
}
