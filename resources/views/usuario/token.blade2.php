

   @include('encabezado')
   

    <h1>Registrar nuevo desarrollador</h1>

    @if (isset($success) && $success)
        <p><strong>Desarrollador creado con éxito:</strong></p>
        <p>Nombre: {{ $apiKey->name }}</p>
        <p>API Key: <code>{{ $apiKey->api_key }}</code></p>
        <hr>
    @endif

    @if ($errors->any())
        <div style="color: red;">
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
        <button type="submit">Crear</button>
    </form>


@include('pie_pagina')
