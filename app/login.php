<?php
session_start(); // Iniciar sesión

// Inicializa la sesión de inicio de sesión
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false; // Inicializa como false si no está definido
}

// Conexión a la base de datos
$servername = "db"; 
$username = "admin";
$password = "test";
$dbname = "database";

// Habilitar reportes de errores para MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");


// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']); // Limpia espacios en blanco
    $pass = trim($_POST['password']);

    // Validar que no estén vacíos
    if (empty($user) || empty($pass)) {
        header("Location: login.html");
        exit();
    }

    // Depurar posibles errores en la consulta
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE (email = ? OR nombre = ?) AND contraseña = ?");
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error); // Muestra el error si `prepare()` falla
    }

    $stmt->bind_param("sss", $user, $user, $pass); // Tipos: s (string)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado, inicia sesión
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user;
        header("Location: index.php"); // Redirige a la página principal
        exit();
    } else {
        // Credenciales incorrectas
        header("Location: login.html");
    }

    $stmt->close();
}

$conn->close();
?>

