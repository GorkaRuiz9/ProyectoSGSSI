<?php

$servidor = "db"; // guardar el nombre del servidor
$usuario = "admin"; // guardar nombre del usuario
$contraseña = "test"; //guardar contraseña
$base_datos = "database"; //guardar nombre base de datos

$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos); //conectarse a la base de datos utilizando los valores correspondientes


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error); //si no ha podido darse la conexión escribirá este mensaje
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

