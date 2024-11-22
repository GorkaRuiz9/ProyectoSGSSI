<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario es 'admin'
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Si no es admin, redirigir a una página de acceso denegado o al inicio
    header("Location: index.php"); // Cambia la URL según lo que necesites
    exit();
}

// Conectar a la base de datos
$servername = "db"; // Cambia esto según tu configuración
$username = "admin";
$password = "test";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Si se recibe una solicitud POST para eliminar un coche
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el nombre del coche a eliminar desde el cuerpo de la solicitud JSON
    $data = json_decode(file_get_contents("php://input"), true);
    $nombreCoche = $data['nombre'];

    // Preparar y ejecutar la consulta para eliminar el coche
    $stmt = $conn->prepare("DELETE FROM coche WHERE nombre = ?");
    if ($stmt) {
        $stmt->bind_param("s", $nombreCoche);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Coche eliminado con éxito."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al eliminar el coche: " . $stmt->error]);
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]);
    }
}

// Obtener todos los coches para cargar en el dropdown
$result = $conn->query("SELECT nombre, marca FROM coche");
$coches = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $coches[] = $row;
    }
    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Eliminar Coche</title>
    
    <!-- Fuente personalizada de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
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
        justify-content: center;
        align-items: center;
        min-height: 50vh;
    }

    /* Estilos de la tabla */
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
        transition: background-color 0.3s ease;
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

    .auth-buttons {
        float: right;
    }

    .auth-btn {
        background-color: #6c63ff;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        margin-left: 10px;
    }

    .auth-btn:hover {
        background-color: #5851db;
    }
    </style>

    <!-- Script adicional que podría manejar la lógica de listado -->
    <script src="js/listado2.js" defer></script>
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
        <h1>Eliminar Coche</h1>
        <div class="eliminar-container">
            <h2>Coches disponibles</h2>
            <label for="coches">Selecciona un coche:</label>
            <select name="coches" id="coches">
                <?php foreach ($coches as $coche): ?>
                    <option value="<?= htmlspecialchars($coche['nombre']) ?>">
                        <?= htmlspecialchars($coche['nombre']) ?> (<?= htmlspecialchars($coche['marca']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <!-- Botón para eliminar el coche seleccionado -->
            <button onclick="eliminarCoche()" name="item_delete_submit">Eliminar coche</button>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
    </footer>

    <script>
        // Función para eliminar el coche seleccionado
        function eliminarCoche() {
            const select = document.getElementById("coches");
            const cocheSeleccionado = select.value;

            // Confirmar antes de eliminar el coche
            if (confirm(`¿Estás seguro de que deseas eliminar el coche: ${cocheSeleccionado}?`)) {
                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ nombre: cocheSeleccionado }) // Enviar el nombre del coche en el cuerpo de la solicitud
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Coche eliminado con éxito.'); // Mensaje de éxito
                        window.location.href = "items.php"; // Redirigir a items.php después de eliminar el coche
                    } else {
                        window.location.href = "items.php"; // Redirigir a items.php después de eliminar el coche
                    }
                })
                .catch(error => {
                    window.location.href = "items.php"; // Redirigir a items.php después de eliminar el coche
                });
            }
        }
    </script>

</body>
</html>

