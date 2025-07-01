@extends('layouts.app')

@section('title', 'Registrar nuevo desarrollador')

@section('content')
    <h1>Registrar nuevo desarrollador</h1>

    @if (isset($success) && $success)
        <div class="success">
            <p><strong>Desarrollador creado con éxito:</strong></p>
            <p>Nombre: {{ $apiKey->name }}</p>
            <p>API Key: <code>{{ $apiKey->api_key }}</code></p>
            <hr>
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

    <form method="POST" action="{{ url('/usuario/token') }}">
        @csrf
        <label for="name">Nombre del desarrollador:</label>
        <input type="text" name="name" id="name" required>
        <button type="submit" style="margin-top: 1em;">Crear</button>
    </form>
@endsection
