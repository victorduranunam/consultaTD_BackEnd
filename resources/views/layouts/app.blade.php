<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'EDUCAFI')</title>
  <link rel="stylesheet" href="{{ asset('CSS/estilos.css') }}" />
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
  <header class="encabezado">
    <!-- Aqu  va tu encabezado -->
  </header>

  <main class="contenido">
    @yield('content')
  </main>

  <footer class="pie">
    <p>&copy;  Transformaci&oacute;n Digital - EDUCAFI  2025</p>
  </footer>
</body>
</html>
