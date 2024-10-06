<?php

$servidor = "db";
$usuario = "admin";
$contraseña = "test";
$base_datos = "database";

$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos);


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener todos los coches
$sql = "SELECT * FROM coche";
$result = $conn->query($sql);

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
$conn->close();
?>

