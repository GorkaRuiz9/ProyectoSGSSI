<?php
// Iniciar sesión para acceder a la variable $_SESSION
session_start();

// Verificar si el usuario es admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Si no es admin, redirigir a una página de acceso denegado o al inicio
    header("Location: index.php"); // Cambia la URL según lo que necesites
    exit();
}

// Conexión a la base de datos
$conn = new mysqli("db", "admin", "test", "database"); // Cambiar credenciales si es necesario
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si se recibe una solicitud POST para añadir un coche
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = trim($_POST['nombre']);
    $marca = trim($_POST['marca']);
    $kilometros = (int)$_POST['kilometros'];
    $plazas = (int)$_POST['plazas'];
    $precio = (float)$_POST['precio'];

    // Preparar la consulta SQL con marcadores de posición
    $stmt = $conn->prepare("INSERT INTO coche (nombre, marca, kilometros, plazas, precio) VALUES (?, ?, ?, ?, ?)");

    // Vincular los parámetros a los marcadores de posición
    $stmt->bind_param("ssiii", $nombre, $marca, $kilometros, $plazas, $precio);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página de listado de coches después de añadir
        header("Location: items.php"); // Cambiar a la URL correcta
        exit(); // Asegúrate de salir después de la redirección
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al añadir el coche: ' . $stmt->error]);
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Añadir Coche</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles1.css">
    <script src="js/listado2.js" defer></script> <!-- Incluye el script listado2.js para funciones adicionales -->
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
        <h1>Añadir un Coche</h1>
        <form id="item_add_form" name="item_add_form" action="" method="POST" onsubmit="validarFormulario(event)">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required> <!-- Campo para el nombre del coche -->

            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" required> <!-- Campo para la marca del coche -->

            <label for="kilometros">Kilómetros:</label>
            <input type="number" id="kilometros" name="kilometros" required> <!-- Campo para los kilómetros -->

            <label for="plazas">Plazas:</label>
            <input type="number" id="plazas" name="plazas" required> <!-- Campo para el número de plazas -->

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required> <!-- Campo para el precio del coche -->

            <button type="submit" name="item_add_submit">Guardar Coche</button> <!-- Botón para enviar el formulario -->
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
    </footer>

    <script>
        // Función para validar los datos del formulario antes de enviarlo
        function validarFormulario(event) {
            event.preventDefault(); // Evitar que se envíe el formulario automáticamente

            // Obtener los valores de los campos
            const nombre = document.getElementById("nombre").value.trim();
            const marca = document.getElementById("marca").value.trim();
            const kilometros = parseInt(document.getElementById("kilometros").value);
            const plazas = parseInt(document.getElementById("plazas").value);
            const precio = parseFloat(document.getElementById("precio").value);

            // Validaciones de los campos
            if (nombre === "" || marca === "") {
                alert("Los campos Nombre y Marca no pueden estar vacíos.");
                return; // Salir de la función si hay error
            }
            if (kilometros < 0) {
                alert("Los kilómetros no pueden ser negativos.");
                return;
            }
            if (plazas <= 0) {
                alert("El número de plazas debe ser mayor que cero.");
                return;
            }
            if (precio <= 0) {
                alert("El precio debe ser mayor que cero.");
                return;
            }

            // Si todas las validaciones pasan, enviar el formulario
            const form = document.getElementById("item_add_form");
            form.submit(); // Envía el formulario
        }
    </script>

</body>
</html>

