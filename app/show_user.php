<?php

session_set_cookie_params([
    'httponly' => true,
    'secure' => isset($_SERVER['HTTPS']), // Asegura que la cookie sea solo para HTTPS
    'samesite' => 'Strict',              // Opcional: protege contra CSRF
]);
session_start(); // Iniciar sesió
session_regenerate_id(true);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html"); // Redirigir al login si no está logueado
    exit();
}

// Variables de conexión
$servername = "db";
$usernameDB = "admin";
$passwordDB = "test";
$dbname = "database";

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname); // Conexión a la base de datos

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el nombre de usuario de la sesión
$user = $_SESSION['username'];

// Sentencia preparada para obtener los datos del usuario
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre = ? OR email = ?");
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Vincular los parámetros
$stmt->bind_param("ss", $user, $user); // 'ss' indica que ambos parámetros son cadenas (strings)

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Obtener los datos del usuario
} else {
    echo "Error: No se encontró el usuario.";
    exit();
}

$stmt->close(); // Cerrar la sentencia
$conn->close(); // Cerrar la conexión
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Usuario</title>
    <style>
        /* Estilos globales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a;
            color: #fff;
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

        /* Estilo del botón de registro */
        .register-btn {
            background-color: #6c63ff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .register-btn:hover {
            background-color: #5851db;
        }

        /* Estilos del main */
        main {
            text-align: center;
            padding: 50px;
        }

        h1 {
            font-size: 2.5em;
            color: #6c63ff;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .car-image {
            width: 100%;
            max-width: 600px;
            height: auto;
            border-radius: 10px;
        }

        /* Estilos del footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
        }

        footer p:hover {
            color: #6c63ff;
        }

        /* Estilos para la página de listado de coches */
        .listado-container {
            display: flex;
            justify-content: space-between;
            padding: 50px;
        }

        /* Columna del dropdown */
        .dropdown-col {
            width: 30%;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 10px;
        }

        /* Columna para el formulario */
        .form-col {
            width: 30%;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 10px;
            margin: 0 20px;
        }

        /* Columna vacía */
        .empty-col {
            width: 30%;
            background-color: #f0f0f0;
            border-radius: 10px;
            height: 300px;
        }

        /* Estilos del dropdown */
        select {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #333;
            background-color: #fff;
            color: #333;
        }

        /* Estilos del formulario */
        form {
            background-color: #3c3c3c;
            padding: 20px;
            border-radius: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #333;
            border-radius: 5px;
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

        /* NUEVOS ESTILOS PARA LA TABLA DE CARACTERÍSTICAS */

        /* Contenedor de la tabla */
        #caracteristicas-container {
            display: flex;
            justify-content: center; /* Centra el contenedor horizontalmente */
            align-items: center; /* Centra el contenedor verticalmente */
            min-height: 50vh; /* Altura mínima para centrar verticalmente */
        }

        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            width: 50%;
            background-color: #fff; /* Fondo blanco */
            color: #333; /* Texto oscuro */
            margin-top: 20px; /* Espacio en la parte superior */
        }

        th, td {
            padding: 10px;
            text-align: left; /* Alineación de texto a la izquierda */
            border-bottom: 1px solid #ddd; /* Línea inferior de las celdas */
            transition: background-color 0.3s ease; /* Efecto de transición para el fondo */
        }

        th {
            background-color: #6c63ff; /* Color de fondo del encabezado */
            color: white; /* Color del texto en el encabezado */
            text-align: center; /* Alineación del texto en el encabezado */
        }

        /* Desactivar efecto al pasar el mouse sobre las celdas */
        td:hover {
            background-color: transparent; /* No cambiar color al pasar el mouse */
            cursor: default; /* Cambia el cursor a default */
        }

        .auth-buttons {
            float: right; /* Alinea los botones a la derecha */
        }

        .auth-btn {
            background-color: #6c63ff; /* Color de fondo */
            color: #fff; /* Color del texto */
            padding: 10px 20px; /* Espaciado */
            border-radius: 5px; /* Bordes redondeados */
            text-decoration: none; /* Sin subrayado */
            font-weight: bold; /* Negrita */
            margin-left: 10px; /* Espaciado entre botones */
        }

        .auth-btn:hover {
            background-color: #5851db; /* Color al pasar el ratón por encima */
        }
    </style>
</head>
<body>

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

