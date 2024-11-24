<?php
ob_start();
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; font-src 'self'; frame-ancestors 'none'; form-action 'self';");
header("X-Content-Type-Options: nosniff");// Agregar el encabezado de seguridad 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Array de errores
    $errores = [];

    // Crear un array con los campos a validar
    $campos_a_validar = [
        'dni' => $dni,
        'telefono' => $telefono,
        'email' => $email
    ];

    // Comprobar si alguno de los valores ya existe en la base de datos (DNI, Teléfono o Email)
    foreach ($campos_a_validar as $campo => $valor) {
        // Preparar consulta para verificar si el valor ya existe
        $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE $campo = ?");
        $stmt->bind_param("s", $valor); // Vinculamos el valor como cadena
        $stmt->execute();
        $stmt->store_result(); // Almacenamos el resultado para verificar el número de filas

        if ($stmt->num_rows > 0) {
            // Si ya existe el campo, agregamos el error al array
            $errores[] = "El $campo ya está registrado.";
        }

        $stmt->close(); // Cerrar el statement después de la validación
    }

    // Validación adicional de campos (por ejemplo, DNI, teléfono, etc.)
    if (empty($errores)) {
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/", $nombre)) {
            $errores[] = "El nombre solo debe contener letras.";
        }
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/", $apellidos)) {
            $errores[] = "Los apellidos solo deben contener letras.";
        }
        if (!preg_match("/^[0-9]{8}-[A-Z]$/", $dni)) {
            $errores[] = "El DNI debe tener el formato 11111111-Z.";
        } else {
            $numeroDNI = substr($dni, 0, 8);
            $letraDNI = strtoupper(substr($dni, -1));
            $letras = "TRWAGMYFPDXBNJZSQVHLCKE"; // Letras válidas según el número de DNI
            $letraCalculada = $letras[$numeroDNI % 23];

            if ($letraDNI !== $letraCalculada) {
                $errores[] = "La letra del DNI no corresponde con el número.";
            }
        }
        if (!preg_match("/^[0-9]{9}$/", $telefono)) {
            $errores[] = "El teléfono debe contener 9 dígitos.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El email no tiene un formato válido.";
        }
    }

    // Si no hubo errores, continuamos con la inserción en la base de datos
    if (empty($errores)) {
        // Preparar la consulta SQL para insertar los datos
        $stmt = $mysqli->prepare("INSERT INTO usuarios (nombre, apellidos, dni, telefono, fecha_nacimiento, email, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nombre, $apellidos, $dni, $telefono, $fecha_nacimiento, $email, $contraseña);

        if ($stmt->execute()) {
            //echo "Registro exitoso.";
            header("Location: index.php");
            exit(); // Detener la ejecución después de redirigir
        } else {
            $errores[] = "Error en el registro: " . $stmt->error;
        }

        $stmt->close();
    }

    // Si hay errores, mostrar todos los errores
    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }

    // Cerrar la conexión
    $mysqli->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    
    <style>
        :root {
            --background-color: #121212; /* Color de fondo oscuro */
            --text-color: #e0e0e0; /* Color del texto claro */
            --text-darkColor: #303030; /* Color del texto oscuro */
            --primary-color: #6c63ff; /* Color primario (botones y enlaces)#bb86fc */
            --border-color: #b8b8b8; /* Color de bordes */
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0; /* Eliminar márgenes por defecto del body */
        }

        h1 {
            color: var(--primary-color);
            text-align: center; /* Centrar el título */
        }

        form {
            max-width: 400px; /* Limitar el ancho del formulario */
            margin: 0 auto; /* Centrar el formulario horizontalmente */
            padding: 35px; /* Espaciado interno para el formulario */
            background-color: #1e1e1e; /* Fondo del formulario */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); /* Sombra para el formulario */
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: calc(100% - 20px); /* Ajustar ancho para evitar desbordamiento */
            padding: 10px;
            margin-top: 5px;
            background-color: #1e1e1e; /* Fondo de los inputs */
            color: var(--text-color);
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }

        input[type="text"]::placeholder,
        input[type="email"]::placeholder {
            color: #a0a0a0; /* Color del placeholder */
        }

        button {
            display: block; /* El botón sea un bloque */
            width: 100%; /* Hacer que el botón ocupe el ancho completo */
            background-color: #6c63ff;
            color: var(--text-color);
            padding: 6px; /* Reducir el padding para hacer el botón más pequeño */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 20px; /* Reducir el tamaño de la fuente */
            margin-top: 15px; /* Espacio superior para el botón */
            font-weight: bold;
        }

        button:hover {
            background-color: #5851db; /* Color al pasar el ratón sobre el botón */
        }
    </style>
</head>
<body>

    <form method="POST" onsubmit="return validarFormulario()">
        <label>Nombre: 
            <input type="text" id="nombre" name="nombre" required placeholder="Ej: Juan"> <!-- Campo para ingresar el nombre -->
        </label><br>

        <label>Apellidos: 
            <input type="text" id="apellidos" name="apellidos" required placeholder="Ej: Pérez"> <!-- Campo para ingresar los apellidos -->
        </label><br>

        <label>DNI: 
            <input type="text" id="dni" name="dni" required placeholder="Ej: 12345678-Z"> <!-- Campo para ingresar el DNI -->
        </label><br>

        <label>Teléfono: 
            <input type="text" id="telefono" name="telefono" required placeholder="Ej: 612345678"> <!-- Campo para ingresar el numero de telefono -->
        </label><br>

        <label>Fecha de Nacimiento: 
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required> <!-- Campo para ingresar la fecha de nacimiento -->
        </label><br>

        <label>Email: 
            <input type="email" id="email" name="email" required placeholder="Ej: ejemplo@dominio.com"> <!-- Campo para ingresar el email -->
        </label><br>
        
        <label>Contraseña: 
            <input type="text" id="contraseña" name="contraseña" required placeholder=""> <!-- Campo para ingresar la contraseña -->
        </label><br>

        <button id="register_submit" type="submit">Registrarse</button> <!-- Botón para enviar el formulario -->
    </form>

</body>
</html>

