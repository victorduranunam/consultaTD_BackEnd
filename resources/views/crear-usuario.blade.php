<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2em;
        }
        form {
            max-width: 400px;
        }
        label {
            display: block;
            margin-top: 1em;
        }
        input {
            width: 100%;
            padding: 0.5em;
        }
        .success {
            color: green;
            margin-bottom: 1em;
        }
        .errors {
            color: red;
            margin-bottom: 1em;
        }
    </style>
</head>
<body>

@include('encabezado')

    <h1>Registrar nuevo usuario</h1>

    @if (session('success'))
        <div class="success">
            <p><strong>Usuario creado con éxito:</strong></p>
            <p>Nombre: {{ session('usuario')->nombre }}</p>
            <p>Email: {{ session('usuario')->email }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/crear-usuario') }}">
        @csrf
        <label for="username">Usuario:</label>
        <input type="text" name="username" id="username" value="{{ old('username') }}" required>
        
         <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" style="margin-top: 1em;">Crear</button>
    </form>



@include('pie_pagina')
