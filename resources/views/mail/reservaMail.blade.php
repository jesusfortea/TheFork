<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Reserva</title>
</head>
<body class="font-sans bg-gray-100 p-10">
    <div class="max-w-[600px] mx-auto bg-white rounded-lg p-8">
        
        <h1 class="text-teal-900">TheFork</h1>
        <hr class="border-t border-gray-200">

        <p>Hola, <strong>{{ $nombreUsuario }}</strong></p>
        <p>Has realizado una reserva para el <strong>{{ $fecha }}</strong> en el restaurante <strong>{{ $nombreRestaurante }}</strong>.</p>

        <a href="{{ url('/') }}"
           class="inline-block mt-4 bg-teal-900 text-white py-[10px] px-[20px] rounded-md no-underline font-bold">
            Ir a TheFork
        </a>

        <p class="mt-8 text-gray-400 text-xs">
            Si no esperabas este correo, puedes ignorarlo.
        </p>
    </div>
</body>
</html>