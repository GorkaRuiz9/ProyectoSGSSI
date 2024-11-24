<?php
session_start(); // Iniciar sesión
header("X-Content-Type-Options: nosniff"); // Agregar el encabezado de seguridad 

// Habilitar los reportes de errores para PHP
//ini_set('display_errors', 1);  // Mostrar errores en pantalla para depuración
//error_reporting(E_ALL);         // Reportar todos los errores

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

// Función para escribir en el log
function writeLog($message) {
    $logFile = "log.txt"; // Ruta absoluta al archivo de log
    $timestamp = date("Y-m-d H:i:s");
    $logMessage = "[$timestamp] $message" . PHP_EOL;

    // Verifica si se puede escribir en el archivo de log
    if (file_put_contents($logFile, $logMessage, FILE_APPEND) === false) {
        // Si no se puede escribir, mostrar un mensaje de error
        error_log("No se pudo escribir en el archivo de log: $message");
    }
}

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']); // Limpia espacios en blanco
    $pass = trim($_POST['password']);

    // Validar que no estén vacíos
    if (empty($user) || empty($pass)) {
        writeLog("Intento de inicio de sesión fallido: campos vacíos.");
        header("Location: login.html");
        exit();
    }

    // Depurar posibles errores en la consulta
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE (email = ? OR nombre = ?) AND contraseña = ?");
    if (!$stmt) {
        writeLog("Error al preparar la consulta: " . $conn->error); // Escribir el error en el log
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sss", $user, $user, $pass); // Tipos: s (string)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado, inicia sesión
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user;
        writeLog("Acceso exitoso: $user.");
        header("Location: index.php"); // Redirige a la página principal
        exit();
    } else {
        // Credenciales incorrectas
        writeLog("Intento de inicio de sesión fallido: $user.");
        header("Location: login.html");
    }

    $stmt->close();
}

$conn->close();
?>

