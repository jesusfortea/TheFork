<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #006252, #004d40); padding: 40px 32px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 26px; }
        .header p { color: rgba(255,255,255,0.8); margin: 8px 0 0; font-size: 14px; }
        .body { padding: 32px; }
        .body p { color: #444; line-height: 1.6; font-size: 15px; }
        .card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px 24px; margin: 24px 0; }
        .card-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        .card-row:last-child { border-bottom: none; }
        .card-row span:first-child { color: #6b7280; font-weight: 600; }
        .card-row span:last-child { color: #111827; font-weight: 700; }
        .footer { background: #f9fafb; padding: 20px 32px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { color: #9ca3af; font-size: 12px; margin: 0; }
        .badge { display: inline-block; background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="container">

        <div class="header">
            <h1>🍽️ TheFork</h1>
            <p>Tu restaurante favorito, siempre a un clic</p>
        </div>

        <div class="body">
            <span class="badge">✅ Reserva confirmada</span>
            <p>Hola, <strong>{{ $reserva->usuario->name }}</strong>.</p>
            <p>Tu reserva ha sido registrada correctamente. Aquí tienes los detalles:</p>

            <div class="card">
                <div class="card-row">
                    <span>Restaurante</span>
                    <span>{{ $reserva->restaurante->titulo }}</span>
                </div>
                <div class="card-row">
                    <span>Ubicación</span>
                    <span>{{ $reserva->restaurante->ubicacion }}</span>
                </div>
                <div class="card-row">
                    <span>Fecha y hora</span>
                    <span>{{ \Carbon\Carbon::parse($reserva->fecha_hora)->format('d/m/Y \a \l\a\s H:i') }}</span>
                </div>
                <div class="card-row">
                    <span>Número de reserva</span>
                    <span>#{{ str_pad($reserva->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

            <p>Si necesitas cancelar o modificar tu reserva, contacta con el restaurante directamente.</p>
            <p>¡Esperamos que disfrutes de una experiencia gastronómica increíble! 🌟</p>
        </div>

        <div class="footer">
            <p>© 2026 TheFork · Este correo se ha enviado automáticamente, por favor no respondas a este mensaje.</p>
        </div>

    </div>
</body>
</html>