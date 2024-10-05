<?php
ob_start(); // Inicia el buffer de salida

// Conexión a la base de datos
$servidor = "db"; // Cambia esto según tu configuración
$usuario = "admin";
$contraseña = "test";
$base_datos = "database";

$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos);

// Verifica si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtén los datos del formulario
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$kilometros = $_POST['kilometros'];
$plazas = $_POST['plazas'];
$precio = $_POST['precio'];

// Actualiza el coche en la base de datos
$sql = "UPDATE coche SET nombre=?, marca=?, kilometros=?, plazas=?, precio=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiiid", $nombre, $marca, $kilometros, $plazas, $precio, $id);

if ($stmt->execute()) {
    // Redirige a listado-coches.html
    header("Location: items.php");
    exit(); // Asegúrate de detener el script después de redirigir
} else {
    echo "Error al modificar el coche: " . $stmt->error;
}

$stmt->close();
$conn->close();
ob_end_flush(); // Envía la salida del buffer
?>

