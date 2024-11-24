<?php
ob_start(); // Inicia el buffer de salida


session_set_cookie_params([
    'httponly' => true,
    'secure' => isset($_SERVER['HTTPS']), // Asegura que la cookie sea solo para HTTPS
    'samesite' => 'Strict',              // Opcional: protege contra CSRF
]);
session_start(); // Iniciar sesió
session_regenerate_id(true);
// Verifica si el usuario ha iniciado sesión y si su nombre es "admin"
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['username'] !== 'admin') {
    // Si no es admin, redirige a la página de inicio de sesión
    header("Location: index.php");
    exit; // Finaliza la ejecución del script para evitar que se cargue la página
}

// Conexión a la base de datos
$servidor = "db"; 
$usuario = "admin";
$contraseña = "test";
$base_datos = "database";

$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos);

// Verifica errores de conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Si se ha enviado el formulario, actualiza el coche en la base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $kilometros = $_POST['kilometros'];
    $plazas = $_POST['plazas'];
    $precio = $_POST['precio'];

    // Actualiza el coche en la base de datos
    $sql = "UPDATE coche SET nombre=?, marca=?, kilometros=?, plazas=?, precio=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiid", $nombre, $marca, $kilometros, $plazas, $precio, $id);

    if ($stmt->execute()) {
        header("Location: items.php"); // Redirige si la actualización es exitosa
        exit(); 
    } else {
        echo "Error al modificar el coche: " . $stmt->error; // Muestra error si falla
    }

    $stmt->close(); // Cierra el statement
    $conn->close(); // Cierra la conexión
    ob_end_flush(); // Envía el contenido del buffer
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Coche</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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

        /* Estilos del main */
        main {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            font-size: 2.5em;
            color: #6c63ff;
        }

        /* Estilos del formulario */
        .form-container {
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin-top: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input {
            margin-top: 5px;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #6c63ff;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #5851db;
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
    </style>
    <script src="js/listado2.js" defer></script> <!-- Referenciamos a los js que hemos hecho para el diseño -->
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

<main>
    <h1>Modificar Coche</h1>
    <div class="form-container">
        <form id="item_modify_form" action="" method="POST" onsubmit="validarFormulario(event)" name="item_modify_form">
            <input type="hidden" id="id" name="id" value="">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" required>
            <label for="kilometros">Kilómetros:</label>
            <input type="number" id="kilometros" name="kilometros" required>
            <label for="plazas">Plazas:</label>
            <input type="number" id="plazas" name="plazas" required>
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>
            <button type="submit" name="item_modify_submit">Actualizar Coche</button>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

<script>
    // Obtener el ID del coche de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const cocheId = urlParams.get('id');

    // Cargar los datos del coche usando el ID
    if (cocheId) {
        fetch(`coche.php?id=${cocheId}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('id').value = data.id;
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('marca').value = data.marca;
                    document.getElementById('kilometros').value = data.kilometros;
                    document.getElementById('plazas').value = data.plazas;
                    document.getElementById('precio').value = data.precio;
                } else {
                    alert("No se encontró el coche.");
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        alert("No se proporcionó un ID de coche.");
    }

    // Función para validar el formulario
    function validarFormulario(event) {
        event.preventDefault(); // Evitar que se envíe el formulario automáticamente

        const nombre = document.getElementById("nombre").value.trim();
        const marca = document.getElementById("marca").value.trim();
        const kilometros = parseInt(document.getElementById("kilometros").value);
        const plazas = parseInt(document.getElementById("plazas").value);
        const precio = parseFloat(document.getElementById("precio").value);

        if (nombre === "" || marca === "") {
            alert("Los campos Nombre y Marca no pueden estar vacíos.");
            return;
        }
        if (kilometros < 0) {
            alert("Los kilómetros no pueden ser negativos.");
            return;
        }
        if (plazas <= 0) {
            alert("El número de plazas debe ser mayor que cero.");
            return;
        }
        if (precio <= 0) {
            alert("El precio debe ser mayor que cero.");
            return;
        }

        // Si todas las validaciones pasan, enviar el formulario
        const form = document.getElementById("item_modify_form");
        form.submit();
    }
</script>

</body>
</html>

