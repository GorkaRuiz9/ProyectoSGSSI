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
    <link rel="stylesheet" href="css/styles1.css"> <!-- Enlazar el archivo CSS externo para los estilos del sitio -->
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

