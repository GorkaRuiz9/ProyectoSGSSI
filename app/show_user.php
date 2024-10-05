<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Redirigir al login si no está logueado
    exit();
}

// Conexión a la base de datos
$servername = "db";
$usernameDB = "admin";
$passwordDB = "test";
$dbname = "database";

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el nombre de usuario de la sesión
$user = $_SESSION['username'];

// Consulta para obtener los datos del usuario
$sql = "SELECT * FROM usuarios WHERE nombre='$user' OR email='$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Obtener los datos del usuario
} else {
    echo "Error: No se encontró el usuario.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Usuario</title>
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>

<header>
    <div class="logo">Concesionario Manolín</div>
    <nav>
        <ul>
            <li><a href="principal.php">Inicio</a></li>
            <li><a href="quienes-somos.html">Quiénes Somos</a></li>
            <li><a href="listado-coches.html">Listado de Coches</a></li>
            <li><a href="contacto.html">Contacto</a></li>
        </ul>
    </nav>
</header>

<main style="text-align: center;">
    <h1>Datos del Usuario</h1>

    <table style="margin: 0 auto;">
        <tr>
            <th>Campo</th>
            <th>Valor</th>
        </tr>
        <tr>
            <td>Nombre</td>
            <td><?php echo $row['nombre']; ?></td>
        </tr>
        <tr>
            <td>Apellidos</td>
            <td><?php echo $row['apellidos']; ?></td>
        </tr>
        <tr>
            <td>DNI</td>
            <td><?php echo $row['dni']; ?></td>
        </tr>
        <tr>
            <td>Teléfono</td>
            <td><?php echo $row['telefono']; ?></td>
        </tr>
        <tr>
            <td>Fecha de Nacimiento</td>
            <td><?php echo $row['fecha_nacimiento']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $row['email']; ?></td>
        </tr>
    </table>
    
    <br>
    <a href="modify_user.php"><button>Modificar Datos</button></a>
</main>

<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

</body>
</html>

