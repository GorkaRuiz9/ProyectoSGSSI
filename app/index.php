<?php
session_start(); // Iniciar sesión para gestionar la información del usuario.
ob_start();
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self'; font-src 'self'; frame-ancestors 'none'; form-action 'self';");
header("X-Content-Type-Options: nosniff"); // Agregar el encabezado de seguridad 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Página Inicial</title>
    <style>
        /* Carga de fuentes locales */
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

        /* Estilos para la página de listado de coches */
        .listado-container {
            display: flex;
            justify-content: space-between;
            padding: 50px;
        }

        /* Columna del dropdown */
        .dropdown-col {
            width: 30%;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 10px;
        }

        /* Columna para el formulario */
        .form-col {
            width: 30%;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 10px;
            margin: 0 20px;
        }

        /* Columna vacía */
        .empty-col {
            width: 30%;
            background-color: #f0f0f0;
            border-radius: 10px;
            height: 300px;
        }

        /* Estilos del dropdown */
        select {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #333;
            background-color: #fff;
            color: #333;
        }

        /* Estilos del formulario */
        form {
            background-color: #3c3c3c;
            padding: 20px;
            border-radius: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #333;
            border-radius: 5px;
        }

        button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #5851db;
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
            display: flex;
            gap: 10px;
        }

        .auth-btn {
            background-color: #6c63ff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
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
            <a href="register.php" id="register-btn" class="auth-btn">Registro</a>
        <?php endif; ?>
    </div>
</header>
<main>
    <h1>Bienvenidos a Concesionario Manolín</h1>
    <p>Descubre los mejores vehículos al mejor precio. Encuentra tu coche ideal con nosotros.</p>
    <img src="foto1.jpeg" alt="Imagen de coche" class="car-image">
</main>
<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>
</body>
</html>

