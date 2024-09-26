<?php
// Conexión a la base de datos (nombre del servicio en Docker: db)
$conn = new mysqli("db", "admin", "test", "database"); // Cambiar credenciales si es necesario
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los coches
$sql = "SELECT nombre, marca FROM coche";
$result = $conn->query($sql);

$coches = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $coches[] = [
            'nombre' => $row['nombre'],
            'marca' => $row['marca']
        ];
    }
}

// Devolver los datos como JSON
header('Content-Type: application/json');
echo json_encode($coches);

// Cerrar conexión
$conn->close();
?>

