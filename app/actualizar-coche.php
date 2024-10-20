<?php
ob_start(); // Inicia el buffer de salida

// Conexión a la base de datos
$servidor = "db"; 
$usuario = "admin";
$contraseña = "test";
$base_datos = "database";

$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos);

// Verifica errores de conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtiene datos del formulario
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
    header("Location: items.php"); // Redirige si la actualización es exitosa
    exit(); 
} else {
    echo "Error al modificar el coche: " . $stmt->error; // Muestra error si falla
}

$stmt->close(); // Cierra el statement
$conn->close(); // Cierra la conexión
ob_end_flush(); // Envía el contenido del buffer
?>
