<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>

    <header>
        <div class="logo">Concesionario Manolín</div>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="quienes-somos.php">Quiénes Somos</a></li>
                <li><a href="listado-coches.php">Listado de Coches</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
        <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
    </header>

    <main style="text-align: center;">
        <h1>Perfil de <?php echo $_SESSION['username']; ?></h1>
        <!-- Aquí puedes agregar el formulario para modificar los datos del usuario -->
        <p>Modificar tus datos de perfil aquí</p>
    </main>

    <footer>
        <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
    </footer>

</body>
</html>

