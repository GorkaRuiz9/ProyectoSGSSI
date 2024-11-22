<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html"); // Redirigir al login si no está logueado
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
$user = $_SESSION['username'];  // Cambia 'username' por el valor adecuado de la sesión

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
    // Si el nombre del usuario es 'admin', redirigir a index.php
    if ($row['nombre'] == 'admin') {
        header("Location: index.php");
        exit();
    }
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
    
    <!-- Estilos embebidos -->
    <style>
        /* Estilos globales */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #1a1a1a;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        /* Estilos del header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 20px;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #fff;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #6c63ff;
        }

        /* Estilos del formulario */
        form {
            background-color: #3c3c3c;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            margin: 50px auto;
        }

        table {
            width: 100%;
            margin: 20px 0;
        }

        td {
            padding: 10px;
            color: #fff;
        }

        input[type="text"], input[type="email"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #333;
            background-color: #fff;
            color: #333;
        }

        button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #5851db;
        }

        /* Estilos del pie de página */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
        }

        footer p:hover {
            color: #6c63ff;
        }
    </style>
    
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

<main style="text-align: center;">
    <h1>Perfil del Usuario</h1>

    <!--Formulario con datos pre-cargados-->
    <form action="modify_user.php" method="post" name="user_modify_form" onsubmit="return validarFormulario()">
        <table style="margin: 0 auto;">
            <tr>
                <td><label for="nombre">Nombre:</label></td>
                <td><input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="apellidos">Apellidos:</label></td>
                <td><input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($row['apellidos']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="dni">DNI:</label></td>
                <td><input type="text" id="dni" name="dni" value="<?php echo htmlspecialchars($row['dni']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="telefono">Teléfono:</label></td>
                <td><input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="fecha_nacimiento">Fecha de Nacimiento:</label></td>
                <td><input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($row['fecha_nacimiento']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required></td>
            </tr>
        </table>
        <br>
        <button type="submit" name="user_modify_submit">Modificar</button>
    </form>
</main>

<!--Pie de página-->
<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

</body>
</html>

