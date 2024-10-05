<?php
session_start(); // Iniciar sesión

// Inicializa la sesión de inicio de sesión
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false; // Inicializa como false si no está definido
}

// Conexión a la base de datos
$servername = "db"; // Cambia esto si es necesario
$username = "admin";
$password = "test";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Consulta para verificar el usuario y la contraseña
    $sql = "SELECT * FROM usuarios WHERE (email='$user' OR nombre='$user') AND contraseña='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuario encontrado, inicia sesión
        $_SESSION['loggedin'] = true; // Marca al usuario como logueado
        $_SESSION['username'] = $user; // Guarda el nombre de usuario en la sesión
        header("Location: principal.php"); // Redirige a la página principal
        exit();
    } else {
        // Credenciales incorrectas
        header("Location: login.html");
    }
}

$conn->close();
?>

