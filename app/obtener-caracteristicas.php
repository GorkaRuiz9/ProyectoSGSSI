<?php
// Conexión a la base de datos
$servername = "db";
$username = "admin";
$password = "test";
$dbname = "database"; 
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el nombre del coche seleccionado
if (isset($_POST['nombre_coche'])) {
    $nombreCoche = $_POST['nombre_coche'];

    // Consultar los detalles del coche seleccionado
    $sql = "SELECT * FROM coche WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombreCoche);
    $stmt->execute();
    $result = $stmt->get_result();

    // Comprobar si hay resultados
    if ($result->num_rows > 0) {
        $coche = $result->fetch_assoc();
        echo json_encode($coche); // Enviar los datos en formato JSON
    } else {
        echo json_encode(['error' => 'No se encontró el coche.']);
    }
    
    $stmt->close();
}
$conn->close();
?>

