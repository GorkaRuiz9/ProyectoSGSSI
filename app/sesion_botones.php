<?php
session_start(); // Inicia la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Página Inicial</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>

<header>
    <div class="logo">Concesionario Manolín</div>
    <nav>
        <ul>
            <li><a href="principal.html">Inicio</a></li>
            <li><a href="quienes-somos.html">Quiénes Somos</a></li>
            <li><a href="listado-coches.html">Listado de Coches</a></li>
            <li><a href="contacto.html">Contacto</a></li>
        </ul>
    </nav>

    <div class="auth-buttons">
        <?php if (isset($_SESSION['username'])): ?>
            <a href="perfil.php" class="auth-btn">Perfil</a>
        <?php else: ?>
            <a href="login.html" class="auth-btn">Iniciar Sesión</a>
            <a href="register.html" class="auth-btn">Registro</a>
        <?php endif; ?>
    </div>
</header>

