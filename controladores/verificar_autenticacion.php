<?php
session_start();

// Verificar si el usuario no está logueado o no es administrador
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../paginas/login_register/login.php');
    exit;
}

// Verificar rol de administrador
if ($_SESSION['rol'] !== 'Admin') {
    header('Location: ../../index.php');
    exit;
}

// Obtener datos del usuario para mostrar
$nombre_usuario = $_SESSION['nombre'] ?? 'Administrador';
$rol_usuario = $_SESSION['rol'] ?? 'Admin';
?>