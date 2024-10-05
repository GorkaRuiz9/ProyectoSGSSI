<?php
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

// Obtener el nombre del coche a eliminar
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

// Cerrar la conexión
$conn->close();
?>

