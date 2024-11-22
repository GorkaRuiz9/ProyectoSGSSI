<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}

// Conexión a la base de datos
$servername = "db";
$username = "admin";
$password = "test";
$dbname = "database"; 
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el nombre del coche seleccionado
$cocheSeleccionado = '';
if (isset($_GET['nombre_coche'])) {
    $cocheSeleccionado = $_GET['nombre_coche'];

    // Consultar los detalles del coche seleccionado
    $sql = "SELECT * FROM coche WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cocheSeleccionado);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $coche = $result->fetch_assoc();
        $caracteristicas = json_encode($coche);
    } else {
        $caracteristicas = json_encode(['error' => 'No se encontró el coche.']);
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Características del Coche</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: #fff;
        }
        header {
            background: #333;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header .logo {
            font-size: 1.8rem;
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
            margin-left: 20px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s ease;
        }
        nav ul li a:hover {
            color: #7b5cf2;
        }
        main {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #7b5cf2;
        }
        #caracteristicas-container {
            width: 100%;
            max-width: 600px;
            background: #333;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }
        #caracteristicas-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        #caracteristicas-table th,
        #caracteristicas-table td {
            border: 1px solid #444;
            padding: 10px;
            text-align: left;
            color: #fff;
        }
        #caracteristicas-table th {
            background-color: #444;
            color: #ddd;
        }
        #caracteristicas-table td {
            background-color: #222;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #7b5cf2;
            color: #fff;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #5a40c9;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
        footer p {
            margin: 0;
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
        <h1>Características del Coche</h1>
        <div id="caracteristicas-container">
            <table id="caracteristicas-table">
                <tr><th>Campo</th><th>Valor</th></tr>
            </table>
            <button onclick="window.history.back()">Volver</button>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const caracteristicas = <?php echo $caracteristicas; ?>;
            
            if (caracteristicas.error) {
                alert(caracteristicas.error);
            } else {
                const table = document.getElementById('caracteristicas-table');
                
                // Iterar sobre las características y excluir el campo 'id'
                for (const [key, value] of Object.entries(caracteristicas)) {
                    if (key !== 'id') { // Excluir el campo 'id'
                        const row = document.createElement('tr');
                        row.innerHTML = `<td>${key}</td><td>${value}</td>`;
                        table.appendChild(row);
                    }
                }
            }
        });
    </script>
</body>
</html>

