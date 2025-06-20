<?php
session_start();

// Verificar si el usuario no está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../paginas/login_register/login.php");
    exit;
}

// Verificar tiempo de inactividad (30 minutos)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: ../paginas/login_register/login.php?timeout=1");
    exit;
}

// Actualizar tiempo de última actividad
$_SESSION['last_activity'] = time();
?>