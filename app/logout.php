<?php


session_set_cookie_params([
    'httponly' => true,
    'secure' => isset($_SERVER['HTTPS']), // Asegura que la cookie sea solo para HTTPS
    'samesite' => 'Strict',              // Opcional: protege contra CSRF
]);
session_start(); // Iniciar sesió
session_regenerate_id(true);
session_destroy(); // Destruye la sesión
header("Location: index.php"); // Redirige a la página principal
exit();
?>

