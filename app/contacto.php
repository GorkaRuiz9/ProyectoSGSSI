<?php

session_set_cookie_params([
    'httponly' => true,
    'secure' => isset($_SERVER['HTTPS']), // Asegura que la cookie sea solo para HTTPS
    'samesite' => 'Strict',              // Opcional: protege contra CSRF
]);
session_start(); // Iniciar sesió
session_regenerate_id(true);
ob_start();
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self'; font-src 'self'; frame-ancestors 'none'; form-action 'self';");
header("X-Content-Type-Options: nosniff"); // Agregar el encabezado de seguridad 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación simple del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Aquí podrías insertar el código para enviar el mensaje o guardarlo en una base de datos
        echo "Mensaje enviado con éxito!";
    } else {
        echo "Por favor ingresa un correo electrónico válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Concesionario Manolín</title>
    <style>
        @font-face {
            font-family: 'Roboto';
            src: url('fonts/Roboto-Regular.ttf') format('truetype'),
                 url('fonts/Roboto-Bold.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Roboto';
            src: url('fonts/Roboto-Bold.ttf') format('truetype');
            font-weight: bold;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a;
            color: #fff;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 20px;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #fff;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #6c63ff;
        }

        main {
            text-align: center;
            padding: 50px;
        }

        h1 {
            font-size: 2.5em;
            color: #6c63ff;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .contact-form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        .contact-form form {
            background-color: #3c3c3c;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #333;
            background-color: #fff;
            color: #333;
        }

        .contact-form button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: #5851db;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
        }

        footer p:hover {
            color: #6c63ff;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">Concesionario Manolín</div>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="quienes-somos.php">Quiénes Somos</a></li>
            <li><a href="items.php">Listado de Coches</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>
</header>

<main>
    <h1>Contacto</h1>
    <p>Si tienes alguna pregunta, comentario o inquietud, no dudes en ponerte en contacto con nosotros.</p>

    <div class="contact-form">
        <form action="contacto.php" method="post">
            <input type="text" name="nombre" placeholder="Tu Nombre" required>
            <input type="email" name="email" placeholder="Tu Correo Electrónico" required>
            <textarea name="mensaje" rows="5" placeholder="Tu Mensaje" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

</body>
</html>

