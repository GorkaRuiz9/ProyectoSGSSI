<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario es 'admin'
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Si no es admin, redirigir a una página de acceso denegado o al inicio
    header("Location: index.php"); // Cambia la URL según lo que necesites
    exit();
}

// Conectar a la base de datos
$servername = "db"; // Cambia esto según tu configuración
$username = "admin";
$password = "test";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Si se recibe una solicitud POST para eliminar un coche
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el nombre del coche a eliminar desde el cuerpo de la solicitud JSON
    $data = json_decode(file_get_contents("php://input"), true);
    $nombreCoche = $data['nombre'];

    // Preparar y ejecutar la consulta para eliminar el coche
    $stmt = $conn->prepare("DELETE FROM coche WHERE nombre = ?");
    if ($stmt) {
        $stmt->bind_param("s", $nombreCoche);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Coche eliminado con éxito."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al eliminar el coche: " . $stmt->error]);
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]);
    }
}

// Obtener todos los coches para cargar en el dropdown
$result = $conn->query("SELECT nombre, marca FROM coche");
$coches = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $coches[] = $row;
    }
    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Eliminar Coche</title>
    
    <!-- Fuente personalizada de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Enlace a la hoja de estilos personalizada -->
    <link rel="stylesheet" href="css/styles1.css">
    
    <!-- Script adicional que podría manejar la lógica de listado -->
    <script src="js/listado2.js" defer></script>
</head>
<body>

    <header>
        <div class="logo">Concesionario Manolín</div>
        <nav>
            <ul>
                <!-- Enlaces de navegación a las diferentes secciones del sitio -->
                <li><a href="index.php">Inicio</a></li>
                <li><a href="quienes-somos.php">Quiénes Somos</a></li>
                <li><a href="items.php">Listado de Coches</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Eliminar Coche</h1>
        <div class="eliminar-container">
            <h2>Coches disponibles</h2>
            <label for="coches">Selecciona un coche:</label>
            <select name="coches" id="coches">
                <?php foreach ($coches as $coche): ?>
                    <option value="<?= htmlspecialchars($coche['nombre']) ?>">
                        <?= htmlspecialchars($coche['nombre']) ?> (<?= htmlspecialchars($coche['marca']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <!-- Botón para eliminar el coche seleccionado -->
            <button onclick="eliminarCoche()" name="item_delete_submit">Eliminar coche</button>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
    </footer>

    <script>
        // Función para eliminar el coche seleccionado
        function eliminarCoche() {
            const select = document.getElementById("coches");
            const cocheSeleccionado = select.value;

            // Confirmar antes de eliminar el coche
            if (confirm(`¿Estás seguro de que deseas eliminar el coche: ${cocheSeleccionado}?`)) {
                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ nombre: cocheSeleccionado }) // Enviar el nombre del coche en el cuerpo de la solicitud
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Coche eliminado con éxito.'); // Mensaje de éxito
                        window.location.href = "items.php"; // Redirigir a items.php después de eliminar el coche
                    } else {
                        window.location.href = "items.php"; // Redirigir a items.php después de eliminar el coche
                    }
                })
                .catch(error => {
                    window.location.href = "items.php"; // Redirigir a items.php después de eliminar el coche
                });
            }
        }
    </script>

</body>
</html>

