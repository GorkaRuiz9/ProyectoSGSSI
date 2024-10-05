<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    
    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";

    // Conexión a la base de datos (ajusta los valores según tu configuración)
    $mysqli = new mysqli($hostname,$username,$password,$db);

    // Verificar si la conexión fue exitosa
    if ($mysqli->connect_error) {
        die("Error de conexión a la base de datos: " . $mysqli->connect_error);
    }

    // Preparar la consulta SQL para insertar los datos
    $stmt = $mysqli->prepare("INSERT INTO usuarios (nombre, apellidos, dni, telefono, fecha_nacimiento, email, contraseña) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellidos, $dni, $telefono, $fecha_nacimiento, $email, $contraseña);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Registro exitoso.";
    } else {
        echo "Error en el registro: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $mysqli->close();
    
    echo "<script>window.location.href='index.php';</script>";
    exit();

}
?>

