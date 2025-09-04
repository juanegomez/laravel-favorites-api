<!DOCTYPE html>
<html>
<head>
    <title>Restablecimiento de Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #3490dc;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #2779bd;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <h2>Restablecer Contraseña</h2>
    
    <p>Hola {{ $user->name }},</p>
    
    <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Si no realizaste esta solicitud, puedes ignorar este correo de forma segura.</p>
    
    <p>Para restablecer tu contraseña, haz clic en el siguiente botón:</p>
    
    <p>
        <a href="{{ $resetLink }}" class="button">Restablecer Contraseña</a>
    </p>
    
    <p>O copia y pega la siguiente URL en tu navegador:</p>
    <p><small>{{ $resetLink }}</small></p>
    
    <p>Este enlace de restablecimiento de contraseña expirará en 24 horas.</p>
    
    <div class="footer">
        <p>Si tienes problemas para hacer clic en el botón, copia y pega la URL en tu navegador web.</p>
        <p>Gracias,<br>El equipo de Soporte</p>
    </div>
</body>
</html>
