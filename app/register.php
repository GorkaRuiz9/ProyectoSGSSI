<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Guardado de información en variables si ha recibido un POST
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    
    // Variables de conexión a la base de datos
    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";

    // Conexión a la base de datos
    $mysqli = new mysqli($hostname, $username, $password, $db);

    // Verificar si la conexión fue exitosa
    if ($mysqli->connect_error) {
        die("Error de conexión a la base de datos: " . $mysqli->connect_error);
    }

    // Preparar la consulta SQL para insertar los datos
    $stmt = $mysqli->prepare("INSERT INTO usuarios (nombre, apellidos, dni, telefono, fecha_nacimiento, email, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nombre, $apellidos, $dni, $telefono, $fecha_nacimiento, $email, $contraseña);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Registro exitoso.";
    } else {
        echo "Error en el registro: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $mysqli->close();

    // Redirigir a otra página después de guardar
    echo "<script>window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    
    <script>
        function validarFormulario() {
            const nombre = document.getElementById("nombre").value.trim();
            const apellidos = document.getElementById("apellidos").value.trim();
            const dni = document.getElementById("dni").value.trim();
            const telefono = document.getElementById("telefono").value.trim();
            const fechaNacimiento = document.getElementById("fecha_nacimiento").value.trim();
            const email = document.getElementById("email").value.trim();
            let errores = []; // Array para almacenar los mensajes de error

            // Validación de nombre y apellidos (solo permite letras y espacios)
            const nombreRegex = /^[\p{L}\s]+$/u;
            if (!nombreRegex.test(nombre)) {
                errores.push("El nombre solo debe contener letras.");
            }
            if (!nombreRegex.test(apellidos)) {
                errores.push("Los apellidos solo deben contener letras.");
            }

            // Validación de DNI (Formato 11111111-Z)
            const dniRegex = /^[0-9]{8}-[A-Z]$/; // Formato de DNI (8 dígitos seguidos de un guion y una letra)
            const letrasDNI = "TRWAGMYFPDXBNJZSQVHLCKE"; // Letras válidas según el número de DNI
            if (!dniRegex.test(dni)) {
                errores.push("El DNI debe tener el formato 11111111-Z.");
            } else {
                const numeroDNI = parseInt(dni.substr(0, 8), 10); // Extraer el número de los primeros 8 caracteres del DNI
                const letraDNI = dni.substr(-1); // Extraer la letra del último carácter
                if (letrasDNI[numeroDNI % 23] !== letraDNI) {
                    errores.push("La letra del DNI no corresponde con el número.");
                }
            }

            // Validación de teléfono (solo 9 dígitos)
            const telefonoRegex = /^[0-9]{9}$/;
            if (!telefonoRegex.test(telefono)) {
                errores.push("El teléfono debe contener 9 dígitos.");
            }

            // Validación de fecha de nacimiento (formato aaaa-mm-dd)
            const fechaRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (!fechaRegex.test(fechaNacimiento)) {
                errores.push("La fecha debe tener el formato aaaa-mm-dd.");
            }

            // Validación de email
            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Acepta emails válidos con caracteres, números y dominios
            if (!emailRegex.test(email)) {
                errores.push("El formato del email no es válido.");
            }

            // Si hay errores, mostramos un mensaje y evitamos que el formulario se envíe
            if (errores.length > 0) {
                alert(errores.join("\n"));
                return false; // Impedir el envío del formulario
            }

            return true; // Si todo es correcto, permitimos el envío del formulario
        }
    </script>
</head>
<body>

    <form method="POST" onsubmit="return validarFormulario()">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required><br>

        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br>

        <button type="submit">Registrar</button>
    </form>

</body>
</html>

