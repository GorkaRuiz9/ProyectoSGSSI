<?php
session_start();
session_destroy(); // Destruye la sesión
header("Location: principal.php"); // Redirige a la página principal
exit();
?>

