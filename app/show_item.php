<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está logueado (por ejemplo, si la sesión tiene el usuario almacenado)
// Verificamos si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no ha iniciado sesión, lo redirigimos a la página de inicio de sesión
    header("Location: login.html");
    exit; // Finalizamos la ejecución del script para evitar que se cargue la página
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

    // Comprobar si hay resultados
    if ($result->num_rows > 0) {
        $coche = $result->fetch_assoc();
        $caracteristicas = json_encode($coche); // Enviar los datos en formato JSON
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
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>

    <header>
        <div class="logo">Concesionario Manolín</div> <!-- Logotipo del concesionario -->
        <nav>
            <ul>
                <!-- Menú de navegación con enlaces a otras páginas del sitio -->
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
                <!-- Aquí se insertarán dinámicamente las características -->
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p> 
    </footer>

    <script>
        // Función para obtener y mostrar las características del coche
        document.addEventListener("DOMContentLoaded", function() {
            const caracteristicas = <?php echo $caracteristicas; ?>;
            
            if (caracteristicas.error) {
                alert(caracteristicas.error);
            } else {
                let table = document.getElementById('caracteristicas-table');
                for (const [key, value] of Object.entries(caracteristicas)) {
                    let row = document.createElement('tr');
                    row.innerHTML = `<td>${key}</td><td>${value}</td>`;
                    table.appendChild(row);
                }
            }
        });
    </script>

</body>
</html>

