<?php
session_start(); // Inicia la sesión para poder acceder a las variables de sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Página Inicial</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Estilos embebidos -->
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

    /* Estilos de los botones de autenticación */
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
    <div class="logo">Concesionario Manolín</div> <!-- Logotipo del concesionario -->
    <nav>
        <ul>
            <!-- Menú de navegación con enlaces a otras páginas del sitio -->
            <li><a href="principal.html">Inicio</a></li>
            <li><a href="quienes-somos.html">Quiénes Somos</a></li>
            <li><a href="listado-coches.html">Listado de Coches</a></li>
            <li><a href="contacto.html">Contacto</a></li>
        </ul>
    </nav>

    <div class="auth-buttons"> <!-- Sección de botones de autenticación (Iniciar sesión / Registro o Perfil) -->
        <?php if (isset($_SESSION['username'])): ?>
            <!-- Si el usuario ha iniciado sesión, se muestra un botón para acceder al perfil -->
            <a href="perfil.php" class="auth-btn">Perfil</a>
        <?php else: ?>
            <!-- Si el usuario no ha iniciado sesión, se muestran los botones de "Iniciar Sesión" y "Registro" -->
            <a href="login.html" class="auth-btn">Iniciar Sesión</a>
            <a href="register.html" class="auth-btn">Registro</a>
        <?php endif; ?>
    </div>
</header>

</body>
</html>

