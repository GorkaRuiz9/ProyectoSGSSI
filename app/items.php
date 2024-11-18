<?php
// Iniciamos la sesión de PHP para manejar la autenticación del usuario
session_start();

// Verificamos si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no ha iniciado sesión, lo redirigimos a la página de inicio de sesión
    header("Location: login.html");
    exit; // Finalizamos la ejecución del script para evitar que se cargue la página
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Listado de Coches</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles1.css">
    <script src="js/listado2.js" defer></script>
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
    <h1>Listado de Coches</h1>
    <div class="listado-container">
        <div class="dropdown-col">
            <h2>Coches disponibles</h2>
            <label for="coches">Selecciona un coche:</label>
            <select name="coches" id="coches" onchange="mostrarCoche()"></select>
            <p id="coche-seleccionado"></p>
        </div>
        <div class="form-col">
            <h2>Opciones</h2>

            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin'): ?>
                <!-- Mostrar los botones solo si el usuario es admin -->
                <button onclick="window.location.href='add_item.php'">Añadir coche</button>
                <button onclick="window.location.href='delete_item.php'">Eliminar coche</button>
                <button onclick="modificarCoche()">Modificar coche</button>
            <?php else: ?>
                <!-- Mensaje para usuarios no autorizados -->
                <p>No tienes permisos para realizar el resto de acciones.</p>
            <?php endif; ?>

            <button onclick="visualizarCaracteristicas()">Visualizar características</button>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

<script>
    // Función para cargar los coches desde el archivo PHP
    document.addEventListener("DOMContentLoaded", function() {
        fetch('listado-coches.php')
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById("coches");
                data.forEach(coche => {
                    let option = document.createElement("option");
                    option.value = coche.nombre;
                    option.setAttribute("data-id", coche.id);
                    option.setAttribute("data-info", coche.marca + " " + coche.nombre);
                    option.textContent = coche.nombre + " (" + coche.marca + ")";
                    select.appendChild(option);
                });
            });
    });

    // Función que se ejecuta cuando seleccionamos un coche
    function mostrarCoche() {
        var select = document.getElementById("coches");
        var selectedOption = select.options[select.selectedIndex];
        var cocheInfo = selectedOption.getAttribute("data-info");
        document.getElementById("coche-seleccionado").innerHTML = cocheInfo;
    }

    // Función para redirigir a la página de modificación del coche seleccionado
    function modificarCoche() {
        const select = document.getElementById("coches");
        const cocheId = select.options[select.selectedIndex].getAttribute("data-id");
        if (!cocheId) {
            alert("Por favor, selecciona un coche para modificar.");
            return;
        }
        window.location.href = `modify_item.php?id=${encodeURIComponent(cocheId)}`;
    }

    // Función para redirigir a la página de características del coche seleccionado
    function visualizarCaracteristicas() {
        const select = document.getElementById("coches");
        const cocheSeleccionado = select.options[select.selectedIndex].value;
        window.location.href = `show_item.php?nombre_coche=${encodeURIComponent(cocheSeleccionado)}`;
    }
</script>

</body>
</html>

