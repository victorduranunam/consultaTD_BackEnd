<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosApiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios_api', function (Blueprint $table) {
            $table->id(); // Columna de ID auto incremental
            $table->string('nombre'); // Columna para el nombre del usuario
            $table->string('email')->unique(); // Columna para el email único
            $table->string('password'); // Columna para la contraseña
            $table->timestamps(); // Columnas para las fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_api'); // Elimina la tabla en caso de rollback
    }
}
