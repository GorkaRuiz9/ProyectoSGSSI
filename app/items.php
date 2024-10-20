<?php
// Iniciamos la sesión de PHP para manejar la autenticación del usuario
#header_remove('X-Powered-By'); // (Opcional) Remover encabezado que indica que PHP está en uso
session_start(); // Iniciar sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Listado de Coches</title> <!-- Título de la página -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Vincular fuente Roboto -->
    <link rel="stylesheet" href="css/styles1.css"> <!-- Vincular hoja de estilos personalizada -->
    <script src="js/listado2.js" defer></script> <!-- Referenciar script para funcionalidad adicional -->
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

    <div class="auth-buttons"> <!-- Contenedor para los botones de autenticación -->
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
    <h1>Listado de Coches</h1> <!-- Título de la sección principal -->
    <div class="listado-container"> <!-- Contenedor para el listado de coches -->
        <div class="dropdown-col"> <!-- Columna para el dropdown de coches -->
            <h2>Coches disponibles</h2> <!-- Título para la lista de coches -->
            <label for="coches">Selecciona un coche:</label> <!-- Etiqueta para el selector -->
            <select name="coches" id="coches" onchange="mostrarCoche()"> <!-- Selector para coches, llama a mostrarCoche al cambiar -->
                <!-- Las opciones serán cargadas dinámicamente desde el archivo PHP -->
            </select>
            <p id="coche-seleccionado"></p> <!-- Elemento para mostrar información del coche seleccionado -->
        </div>
        <div class="form-col"> <!-- Columna para las opciones de acciones -->
            <h2>Opciones</h2> <!-- Título para las opciones -->
            <button onclick="window.location.href='add_item.html'">Añadir coche</button> <!-- Botón para añadir coche -->
            <button onclick="window.location.href='delete_item.html'">Eliminar coche</button> <!-- Botón para eliminar coche -->
            <button onclick="modificarCoche()">Modificar coche</button> <!-- Botón para modificar coche -->
            <button onclick="visualizarCaracteristicas()">Visualizar características</button> <!-- Botón para visualizar características -->
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p> <!-- Información de derechos reservados -->
</footer>

<script>
    // Función para cargar los coches desde el archivo PHP
    document.addEventListener("DOMContentLoaded", function() {
        fetch('listado-coches.php') // Realizar una petición para obtener la lista de coches
            .then(response => response.json()) // Convertir la respuesta a JSON
            .then(data => {
                let select = document.getElementById("coches"); // Obtener el elemento select
                data.forEach(coche => {
                    let option = document.createElement("option"); // Crear un nuevo elemento option
                    option.value = coche.nombre; // Asignar el nombre del coche como valor
                    option.setAttribute("data-id", coche.id); // Agregar el ID del coche como atributo
                    option.setAttribute("data-info", coche.marca + " " + coche.nombre); // Agregar información del coche
                    option.textContent = coche.nombre + " (" + coche.marca + ")"; // Texto a mostrar en la opción
                    select.appendChild(option); // Añadir la opción al select
                });
            });
    });

    // Función que se ejecuta cuando seleccionamos un coche
    function mostrarCoche() {
        var select = document.getElementById("coches"); // Obtener el select
        var selectedOption = select.options[select.selectedIndex]; // Obtener la opción seleccionada
        var cocheInfo = selectedOption.getAttribute("data-info"); // Obtener información del coche seleccionado
        document.getElementById("coche-seleccionado").innerHTML = cocheInfo; // Mostrar información del coche
    }

    // Función para redirigir a la página de modificación del coche seleccionado
    function modificarCoche() {
        const select = document.getElementById("coches"); // Obtener el select
        const cocheId = select.options[select.selectedIndex].getAttribute("data-id"); // Obtener ID del coche seleccionado
        if (!cocheId) { // Verificar que se haya seleccionado un coche
            alert("Por favor, selecciona un coche para modificar."); // Alerta si no se seleccionó coche
            return; // Salir de la función
        }
        window.location.href = `modify_item.html?id=${encodeURIComponent(cocheId)}`; // Redirigir a la página de modificación
    }

    // Función para redirigir a la página de características del coche seleccionado
    function visualizarCaracteristicas() {
        const select = document.getElementById("coches"); // Obtener el select
        const cocheSeleccionado = select.options[select.selectedIndex].value; // Obtener nombre del coche seleccionado
        window.location.href = `show_item.html?nombre_coche=${encodeURIComponent(cocheSeleccionado)}`; // Redirigir a la página de características
    }
</script>

</body>
</html>
