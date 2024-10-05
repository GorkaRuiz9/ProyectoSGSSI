<?php
session_start();

// Simulación de base de datos 
$usuarios = [
    'usuario1' => 'password1',
    'usuario2' => 'password2',
];

$username = $_POST['username'];
$password = $_POST['password'];

// Verificar credenciales
if (isset($usuarios[$username]) && $usuarios[$username] === $password) {
    // Credenciales correctas, crear sesión
    $_SESSION['username'] = $username;
    header('Location: index.php');
    exit;
} else {
    // Credenciales incorrectas
    echo "Usuario o contraseña incorrectos.";
}
?>

