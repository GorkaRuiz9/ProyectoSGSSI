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
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre = ? OR email = ?");
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->bind_param("ss", $user, $user); // 'ss' indica que ambos parámetros son de tipo string
$stmt->execute();
$result = $stmt->get_result();

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
    $update_stmt = $conn->prepare("UPDATE usuarios SET 
                                    nombre = ?, 
                                    apellidos = ?, 
                                    dni = ?, 
                                    telefono = ?, 
                                    fecha_nacimiento = ?, 
                                    email = ? 
                                    WHERE nombre = ? OR email = ?");
    if ($update_stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $update_stmt->bind_param("ssssssss", $nombre, $apellidos, $dni, $telefono, $fecha_nacimiento, $email, $user, $user); // Vinculando parámetros de entrada
    if ($update_stmt->execute()) {
        $_SESSION['username'] = $nombre; // Actualizar el nombre de usuario en la sesión si se cambió
        header("Location: index.php");
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }

    // Cerrar la sentencia de actualización
    $update_stmt->close();
}

// Cerrar la sentencia de selección y la conexión
$stmt->close();
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
<!--Encabezado-->
<header>
    <div class="logo">Concesionario Manolín</div>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="quienes-somos.php">Quiénes Somos</a></li>
            <li><a href="items.php">Listado de Coches</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>
</header>
<!--Permite modificar los datos del usuario pero para haya obtenemos primero de la base de datos la información que vamos a cambiar-->
<main style="text-align: center;">
    <h1>Perfil del Usuario</h1>

    <form id="" action="modify_user.php" method="post" name="user_modify_form" onsubmit="return validarFormulario()">
        <table style="margin: 0 auto;">
            <tr>
                <td><label for="nombre">Nombre:</label></td>
                <td><input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required></td> <!--Modificamos nombre-->
            </tr>
            <tr>
                <td><label for="apellidos">Apellidos:</label></td>
                <td><input type="text" id="apellidos" name="apellidos" value="<?php echo $row['apellidos']; ?>" required></td> <!--Modificamos apellido-->
            </tr>
            <tr>
                <td><label for="dni">DNI:</label></td>
                <td><input type="text" id="dni" name="dni" value="<?php echo $row['dni']; ?>" required></td> <!--Modificamos DNI-->
            </tr>
            <tr>
                <td><label for="telefono">Teléfono:</label></td>
                <td><input type="text" id="telefono" name="telefono" value="<?php echo $row['telefono']; ?>" required></td> <!--Modificamos teléfono-->
            </tr>
            <tr>
                <td><label for="fecha_nacimiento">Fecha de Nacimiento:</label></td> <!--Modificamos fecha de nacimiento-->
                <td><input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $row['fecha_nacimiento']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td> <!--Modificamos el email--> 
                <td><input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required></td>
            </tr>
        </table>
        <br>
        <button type="submit" name="user_modify_submit">Modificar</button> <!--Botón para enviar todo-->
    </form>
</main>
<!--Pie de página-->
<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

</body>
</html>

