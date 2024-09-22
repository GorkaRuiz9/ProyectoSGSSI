<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $email = $_POST['email'];
    $errores = [];

    // Validación de nombre y apellidos (solo texto)
    if (!preg_match("/^[a-zA-Z ]+$/", $nombre)) {
        $errores[] = "El nombre solo debe contener letras.";
    }
    if (!preg_match("/^[a-zA-Z ]+$/", $apellidos)) {
        $errores[] = "Los apellidos solo deben contener letras.";
    }

    // Validación de DNI (Formato 11111111-Z)
    if (!preg_match("/^[0-9]{8}-[A-Za-z]$/", $dni)) {
        $errores[] = "El DNI debe tener el formato 11111111-Z.";
    } else {
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
        $numero = substr($dni, 0, 8);
        $letra = strtoupper(substr($dni, -1));
        if ($letras[$numero % 23] !== $letra) {
            $errores[] = "La letra del DNI no corresponde con el número.";
        }
    }

    // Validación de teléfono (solo números de 9 dígitos)
    if (!preg_match("/^[0-9]{9}$/", $telefono)) {
        $errores[] = "El teléfono debe contener 9 dígitos.";
    }

    // Validación de fecha de nacimiento (formato aaaa-mm-dd)
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha_nacimiento)) {
        $errores[] = "La fecha debe tener el formato aaaa-mm-dd.";
    }

    // Validación de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido.";
    }

    // Si no hay errores, puedes guardar los datos en la base de datos
    if (empty($errores)) {
        // Conexión a la base de datos (asegúrate de tener configurada la base de datos correctamente)
        $mysqli = new mysqli("localhost", "root", "password", "mi_base_datos");
        if ($mysqli->connect_error) {
            die("Error de conexión a la base de datos: " . $mysqli->connect_error);
        }

        $stmt = $mysqli->prepare("INSERT INTO usuarios (nombre, apellidos, dni, telefono, fecha_nacimiento, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombre, $apellidos, $dni, $telefono, $fecha_nacimiento, $email);

        if ($stmt->execute()) {
            echo "Registro exitoso.";
        } else {
            echo "Error en el registro: " . $stmt->error;
        }

        $stmt->close();
        $mysqli->close();
    } else {
        // Mostrar los errores
        foreach ($errores as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
</head>
<body>
    <h1>Registro de Usuarios</h1>
    <form action="register.php" method="POST">
        <label>Nombre: <input type="text" name="nombre" required placeholder="Ej: Juan"></label><br>
        <label>Apellidos: <input type="text" name="apellidos" required placeholder="Ej: Manuel"></label><br>
        <label>DNI: <input type="text" name="dni" required placeholder="Ej: 11111111-8"></label><br>
        <label>Teléfono: <input type="text" name="telefono" required placeholder="Ej: 111111111"></label><br>
        <label>Fecha de Nacimiento: <input type="date" name="fecha_nacimiento" required></label><br>
        <label>Email: <input type="email" name="email" required placeholder="Ej: algo@algo.com"></label><br>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>

