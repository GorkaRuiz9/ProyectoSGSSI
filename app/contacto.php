<?php
// Iniciamos la sesión de PHP 
#header_remove('X-Powered-By');
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Concesionario Manolín</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles1.css">
    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        footer {
            text-align: center;
            background-color: #333;
            padding: 10px 0;
            color: #ffffff;
        }

        .contact-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #1a1a1a;
            text-align: center;
        }

        .contact-form input, .contact-form textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #ffffff;
            color: #1a1a1a;
        }

        .contact-form textarea {
            resize: none;
        }

        .contact-form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .contact-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">Concesionario Manolín</div>
    <nav>
        <ul>
            <li><a href="principal.php">Inicio</a></li>
            <li><a href="quienes-somos.php">Quiénes Somos</a></li>
            <li><a href="items.php">Listado de Coches</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>

    <div class="auth-buttons">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <a href="perfil.php" id="profile-btn" class="auth-btn">Perfil</a>
            <a href="logout.php" class="auth-btn">Cerrar Sesión</a>
        <?php else: ?>
            <a href="login.html" id="login-btn" class="auth-btn">Iniciar Sesión</a>
            <a href="register.html" id="register-btn" class="auth-btn">Registro</a>
        <?php endif; ?>
    </div>
</header>

<main style="text-align: center;">
    <h1>Contacto</h1>
    <p>Si tienes alguna pregunta, comentario o inquietud, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte.</p>

    <div class="contact-form">
        <h2>Formulario de Contacto</h2>
        <form action="#" method="post">
            <input type="text" name="nombre" placeholder="Tu Nombre" required>
            <input type="email" name="email" placeholder="Tu Correo Electrónico" required>
            <textarea name="mensaje" rows="5" placeholder="Tu Mensaje" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>

    <h2>Información de Contacto</h2>
    <p><strong>Teléfono:</strong> +34 (408) 102-1436</p>
    <p><strong>Email:</strong> contacto@concesionariomanolin.com</p>
    <p><strong>Dirección:</strong> Calle Manuel Allende, 4, Abando, 48010 Bilbao, Bizkaia</p>

    <div style="margin-top: 30px;">
        <h2>Síguenos en nuestras redes sociales</h2>
        <p><a href="https://instagram.com/ConcesionarioManolin" target="_blank">Instagram</a></p>
        <p><a href="https://facebook.com/ConcesionarioManolinBilbao" target="_blank">Facebook</a></p>
        <p><a href="https://twitter.com/ManolinCochesBilbao" target="_blank">Twitter</a></p>
    </div>
</main>

<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

</body>
</html>

