<?php
// Conexión a la base de datos (nombre del servicio en Docker: db)
$conn = new mysqli("db", "admin", "test", "database"); // Cambiar credenciales si es necesario
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si se recibe una solicitud POST para añadir un coche
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $conn->real_escape_string(trim($_POST['nombre']));
    $marca = $conn->real_escape_string(trim($_POST['marca']));
    $kilometros = (int)$_POST['kilometros'];
    $plazas = (int)$_POST['plazas'];
    $precio = (float)$_POST['precio'];

    // Insertar el nuevo coche en la base de datos
    $sql_insert = "INSERT INTO coche (nombre, marca, kilometros, plazas, precio) VALUES ('$nombre', '$marca', $kilometros, $plazas, $precio)";

    if ($conn->query($sql_insert) === TRUE) {
        // Redirigir a la página de listado de coches después de añadir
        header("Location: listado-coches.html"); // Cambiar a la URL correcta
        exit(); // Asegúrate de salir después de la redirección
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al añadir el coche: ' . $conn->error]);
    }
}

// Cerrar conexión
$conn->close();
?>

