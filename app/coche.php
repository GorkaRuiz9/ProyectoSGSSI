<?php
// Conexión a la base de datos
$servidor = "db";
$usuario = "admin";
$contraseña = "test";
$base_datos = "database";

$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos);

// Verifica si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtiene el ID del coche de la URL
$id = $_GET['id'];

// Consulta para obtener los datos del coche
$sql = "SELECT * FROM coche WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si se encontró el coche
if ($result->num_rows > 0) {
    $coche = $result->fetch_assoc();
    echo json_encode($coche); // Devuelve los datos en formato JSON
} else {
    echo json_encode([]);
}

// Cierra la conexión
$stmt->close();
$conn->close();
?>

