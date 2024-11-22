<?php
// Iniciar sesión para acceder a la variable $_SESSION
session_start();

// Verificar si el usuario es admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Si no es admin, redirigir a una página de acceso denegado o al inicio
    header("Location: index.php"); // Cambia la URL según lo que necesites
    exit();
}

// Conexión a la base de datos
$conn = new mysqli("db", "admin", "test", "database"); // Cambiar credenciales si es necesario
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si se recibe una solicitud POST para añadir un coche
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = trim($_POST['nombre']);
    $marca = trim($_POST['marca']);
    $kilometros = (int)$_POST['kilometros'];
    $plazas = (int)$_POST['plazas'];
    $precio = (float)$_POST['precio'];

    // Preparar la consulta SQL con marcadores de posición
    $stmt = $conn->prepare("INSERT INTO coche (nombre, marca, kilometros, plazas, precio) VALUES (?, ?, ?, ?, ?)");

    // Vincular los parámetros a los marcadores de posición
    $stmt->bind_param("ssiii", $nombre, $marca, $kilometros, $plazas, $precio);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página de listado de coches después de añadir
        header("Location: items.php"); // Cambiar a la URL correcta
        exit(); // Asegúrate de salir después de la redirección
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al añadir el coche: ' . $stmt->error]);
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Añadir Coche</title>

    <!-- Estilos embebidos -->
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

        /* Estilos del formulario */
        form {
            background-color: #3c3c3c;
            padding: 20px;
            border-radius: 10px;
        }

        label {
            font-size: 16px;
            margin: 10px 0 5px;
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

        /* Columna para el formulario */
        .form-col {
            width: 30%;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 10px;
            margin: 0 20px;
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

        /* NUEVOS ESTILOS PARA LA TABLA DE CARACTERÍSTICAS */
        table {
            border-collapse: collapse;
            width: 50%;
            background-color: #fff;
            color: #333;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #6c63ff;
            color: white;
            text-align: center;
        }

        td:hover {
            background-color: transparent;
            cursor: default;
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

    <main>
        <h1>Añadir un Coche</h1>
        <form id="item_add_form" name="item_add_form" action="" method="POST" onsubmit="validarFormulario(event)">
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

            <button type="submit" name="item_add_submit">Guardar Coche</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
    </footer>

    <script>
        function validarFormulario(event) {
            event.preventDefault(); // Evitar el envío del formulario

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

            const form = document.getElementById("item_add_form");
            form.submit();
        }
    </script>

</body>
</html>

