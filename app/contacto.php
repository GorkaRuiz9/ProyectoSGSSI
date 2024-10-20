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

    <!-- Fuente personalizada de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Enlace a la hoja de estilos personalizada -->
    <link rel="stylesheet" href="css/styles1.css">

    <style>
        /* Estilos generales para la página */
        body {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        /* Estilos para el pie de página */
        footer {
            text-align: center;
            background-color: #333;
            padding: 10px 0;
            color: #ffffff;
        }

        /* Estilos para el formulario de contacto */
        .contact-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #1a1a1a;
            text-align: center;
        }

        /* Estilos para los campos del formulario */
        .contact-form input, .contact-form textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #ffffff;
            color: #1a1a1a;
        }

        /* El textarea no se puede redimensionar */
        .contact-form textarea {
            resize: none;
        }

        /* Estilos para el botón de envío del formulario */
        .contact-form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        /* Efecto hover para el botón de envío */
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
            <!-- Enlaces a las diferentes secciones del sitio -->
            <li><a href="index.php">Inicio</a></li>
            <li><a href="quienes-somos.php">Quiénes Somos</a></li>
            <li><a href="items.php">Listado de Coches</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>

    <div class="auth-buttons">
        <!-- Verifica si el usuario está autenticado y muestra los botones correspondientes -->
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <!-- Si el usuario está logueado, muestra los enlaces al perfil y para cerrar sesión -->
            <a href="show_user.php" id="profile-btn" class="auth-btn">Perfil</a>
            <a href="logout.php" class="auth-btn">Cerrar Sesión</a>
        <?php else: ?>
            <!-- Si no está logueado, muestra las opciones de inicio de sesión y registro -->
            <a href="login.html" id="login-btn" class="auth-btn">Iniciar Sesión</a>
            <a href="register.html" id="register-btn" class="auth-btn">Registro</a>
        <?php endif; ?>
    </div>
</header>

<main style="text-align: center;">
    <h1>Contacto</h1>
    <p>Si tienes alguna pregunta, comentario o inquietud, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte.</p>

    <!-- Formulario de contacto -->
    <div class="contact-form">
        <h2>Formulario de Contacto</h2>
        <form action="#" method="post">
            <!-- Campo para el nombre del usuario -->
            <input type="text" name="nombre" placeholder="Tu Nombre" required>

            <!-- Campo para el correo electrónico del usuario -->
            <input type="email" name="email" placeholder="Tu Correo Electrónico" required>

            <!-- Campo para el mensaje del usuario -->
            <textarea name="mensaje" rows="5" placeholder="Tu Mensaje" required></textarea>

            <!-- Botón para enviar el formulario -->
            <button type="submit">Enviar</button>
        </form>
    </div>

    <!-- Sección de información de contacto -->
    <h2>Información de Contacto</h2>
    <p><strong>Teléfono:</strong> +34 (408) 102-1436</p>
    <p><strong>Email:</strong> contacto@concesionariomanolin.com</p>
    <p><strong>Dirección:</strong> Calle Manuel Allende, 4, Abando, 48010 Bilbao, Bizkaia</p>

    <!-- Sección de redes sociales -->
    <div style="margin-top: 30px;">
        <h2>Síguenos en nuestras redes sociales</h2>
        <p><a href="https://instagram.com/ConcesionarioManolin" target="_blank">Instagram</a></p>
        <p><a href="https://facebook.com/ConcesionarioManolinBilbao" target="_blank">Facebook</a></p>
        <p><a href="https://twitter.com/ManolinCoches" target="_blank">Twitter</a></p>
    </div>
</main>

<!-- Pie de página con los derechos reservados -->
<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

</body>
</html>
