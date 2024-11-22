<?php
session_start();
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos globales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a;
            color: #fff;
        }

        /* Estilos del header */
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

        /* Estilo del botón de registro */
        .register-btn {
            background-color: #6c63ff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .register-btn:hover {
            background-color: #5851db;
        }

        /* Estilos del main */
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

        .car-image {
            width: 100%;
            max-width: 600px;
            height: auto;
            border-radius: 10px;
        }

        /* Estilos del footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
        }

        footer p:hover {
            color: #6c63ff;
        }

        /* Estilos para la página de contacto */
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
            width: 400px; /* Asegura que el cuadro sea de un tamaño adecuado */
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

        /* Información de contacto */
        .contact-info {
            margin-top: 30px;
            text-align: center;
        }

        .contact-info p {
            font-size: 1.1em;
        }

        .contact-info a {
            color: #6c63ff;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        /* NUEVOS ESTILOS PARA LA TABLA DE CARACTERÍSTICAS */
        #caracteristicas-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
        }

        table {
            border-collapse: collapse;
            width: 50%;
            background-color: #fff;
            color: #333;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }

        th {
            background-color: #6c63ff;
            color: white;
            text-align: center;
        }

        td:hover {
            background-color: transparent;
            cursor: default;
        }

        .auth-buttons {
            float: right;
        }

        .auth-btn {
            background-color: #6c63ff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
        }

        .auth-btn:hover {
            background-color: #5851db;
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

    <div class="auth-buttons">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <a href="show_user.php" id="profile-btn" class="auth-btn">Perfil</a>
            <a href="logout.php" class="auth-btn">Cerrar Sesión</a>
        <?php else: ?>
            <a href="login.html" id="login-btn" class="auth-btn">Iniciar Sesión</a>
            <a href="register.html" id="register-btn" class="auth-btn">Registro</a>
        <?php endif; ?>
    </div>
</header>

<main>
    <h1>Contacto</h1>
    <p>Si tienes alguna pregunta, comentario o inquietud, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte.</p>

    <div class="contact-form">
        <form action="contacto.php" method="post">
            <input type="text" name="nombre" placeholder="Tu Nombre" required>
            <input type="email" name="email" placeholder="Tu Correo Electrónico" required>
            <textarea name="mensaje" rows="5" placeholder="Tu Mensaje" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>

    <div class="contact-info">
        <h2>Información de Contacto</h2>
        <p><strong>Teléfono:</strong> +34 (408) 102-1436</p>
        <p><strong>Email:</strong> contacto@concesionariomanolin.com</p>
        <p><strong>Dirección:</strong> Calle Manuel Allende, 4, Abando, 48010 Bilbao, Bizkaia</p>
        <p><strong>Síguenos en nuestras redes sociales:</strong></p>
        <p><a href="https://instagram.com/ConcesionarioManolin" target="_blank">Instagram</a></p>
        <p><a href="https://facebook.com/ConcesionarioManolinBilbao" target="_blank">Facebook</a></p>
        <p><a href="https://twitter.com/ManolinCoches" target="_blank">Twitter</a></p>
    </div>
</main>

<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

</body>
</html>

