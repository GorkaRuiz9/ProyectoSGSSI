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

// Verificar si se ha enviado el formulario para actualizar los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $email = $_POST['email'];

    // Consulta para actualizar los datos del usuario en la base de datos
    $update_sql = "UPDATE usuarios SET 
                    nombre='$nombre', 
                    apellidos='$apellidos', 
                    dni='$dni', 
                    telefono='$telefono', 
                    fecha_nacimiento='$fecha_nacimiento', 
                    email='$email' 
                   WHERE nombre='$user' OR email='$user'";

    if ($conn->query($update_sql) === TRUE) {
        //echo "Datos actualizados correctamente.";
        $_SESSION['username'] = $nombre; // Actualizar el nombre de usuario en la sesión si se cambió
        header("Location: principal.php");
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="css/styles1.css">
    <script src="js/validaciones.js"></script> <!-- Enlace al archivo de validación -->
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
    <h1>Perfil del Usuario</h1>

    <form id="" action="modify_user.php" method="post" name="user_modify_form" onsubmit="return validarFormulario()">
        <table style="margin: 0 auto;">
            <tr>
                <td><label for="nombre">Nombre:</label></td>
                <td><input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="apellidos">Apellidos:</label></td>
                <td><input type="text" id="apellidos" name="apellidos" value="<?php echo $row['apellidos']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="dni">DNI:</label></td>
                <td><input type="text" id="dni" name="dni" value="<?php echo $row['dni']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="telefono">Teléfono:</label></td>
                <td><input type="text" id="telefono" name="telefono" value="<?php echo $row['telefono']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="fecha_nacimiento">Fecha de Nacimiento:</label></td>
                <td><input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $row['fecha_nacimiento']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required></td>
            </tr>
        </table>
        <br>
        <button type="submit" name="user_modify_submit">Modificar</button>
    </form>
</main>

<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

</body>
</html>

