<?php

$servidor = "db"; // nombre del servidor
$usuario = "admin"; // nombre del usuario
$contraseña = "test"; // contraseña
$base_datos = "database"; // nombre de la base de datos

// Conexión a la base de datos
$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error); // Mensaje de error si la conexión falla
}

// Consulta preparada para obtener todos los coches
$stmt = $conn->prepare("SELECT * FROM coche");
$stmt->execute();
$result = $stmt->get_result();

// Array para almacenar los coches
$coches = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $coches[] = $row;
    }
}

// Devuelve los coches en formato JSON
header('Content-Type: application/json');
echo json_encode($coches);

// Cierra la conexión
$stmt->close();
$conn->close();
?>

