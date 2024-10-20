<?php
session_start(); // Iniciar sesión para gestionar la información del usuario.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Página Inicial</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Vincular fuente Roboto -->
    <link rel="stylesheet" href="css/styles1.css"> <!-- Vincular hoja de estilos personalizada -->
    <style>
        .auth-buttons {
            display: flex; /* Utiliza flexbox para organizar los botones de autenticación */
            gap: 10px; /* Espacio entre los botones */
        }
    </style>
</head>
<body>

<header>
    <div class="logo">Concesionario Manolín</div> <!-- Logo del concesionario -->
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li> <!-- Enlace a la página de inicio -->
            <li><a href="quienes-somos.php">Quiénes Somos</a></li> <!-- Enlace a la página de información -->
            <li><a href="items.php">Listado de Coches</a></li> <!-- Enlace al listado de coches -->
            <li><a href="contacto.php">Contacto</a></li> <!-- Enlace a la página de contacto -->
        </ul>
    </nav>

    <div class="auth-buttons">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <!-- Si el usuario está autenticado, mostrar enlaces a perfil y cerrar sesión -->
            <a href="show_user.php" id="profile-btn" class="auth-btn">Perfil</a>
            <a href="logout.php" class="auth-btn">Cerrar Sesión</a>
        <?php else: ?>
            <!-- Si el usuario no está autenticado, mostrar enlaces para iniciar sesión y registrarse -->
            <a href="login.html" id="login-btn" class="auth-btn">Iniciar Sesión</a>
            <a href="register.html" id="register-btn" class="auth-btn">Registro</a>
        <?php endif; ?>
    </div>
</header>

<main>
    <h1>Bienvenidos a Concesionario Manolín</h1> <!-- Título principal de la página -->
    <p>Descubre los mejores vehículos al mejor precio. Encuentra tu coche ideal con nosotros.</p> <!-- Descripción del concesionario -->
    <img src="car1.jpg" alt="Imagen de coche" class="car-image"> <!-- Imagen representativa de los coches -->
</main>

<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p> <!-- Información de derechos reservados -->
</footer>

<?php
// Iniciamos la sesión de PHP para mantener el estado del usuario.
#header_remove('X-Powered-By'); // Opcional: Remover encabezados que indican que PHP está en uso.

 // Incluimos el contenido de principal.html (si es necesario en otro lugar).
?>

</body>
</html>
