<?php
// Conexión a la base de datos (nombre del servicio en Docker: db)
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

