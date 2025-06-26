<?php
session_start();
require_once '../controladores/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener y sanitizar datos
    $apellidoPaterno = $conexion->real_escape_string(trim($_POST['apellidoPaterno']));
    $apellidoMaterno = isset($_POST['apellidoMaterno']) ? $conexion->real_escape_string(trim($_POST['apellidoMaterno'])) : null;
    $nombre = $conexion->real_escape_string(trim($_POST['nombre']));
    $usuario = $conexion->real_escape_string(trim($_POST['usuario']));
    $email = $conexion->real_escape_string(trim($_POST['email']));
    $telefono = $conexion->real_escape_string(trim($_POST['telefono']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validaciones básicas
    $errors = [];
    
    if (empty($nombre) || empty($apellidoPaterno) || empty($usuario) || empty($email) || empty($telefono) || empty($password)) {
        $errors[] = "Los campos marcados con * son obligatorios";
    }
    
    if (strlen($nombre) > 50 || strlen($apellidoPaterno) > 50 || (isset($apellidoMaterno) && strlen($apellidoMaterno) > 50)) {
        $errors[] = "Los nombres y apellidos no deben exceder los 50 caracteres";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Las contraseñas no coinciden";
    }
    
    if (strlen($password) < 8) {
        $errors[] = "La contraseña debe tener al menos 8 caracteres";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El formato del correo electrónico no es válido";
    }

    // Verificar si el usuario, email o teléfono ya existen
    $check_query = "SELECT idCliente FROM cliente WHERE usuario = ? OR email = ? OR telefono = ?";
    $stmt_check = $conexion->prepare($check_query);
    $stmt_check->bind_param("sss", $usuario, $email, $telefono);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        $errors[] = "El nombre de usuario, correo electrónico o teléfono ya están registrados";
    }

    // Si hay errores, redirigir con mensajes
    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: ../paginas/login_register/register.php");
        exit;
    }

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo cliente
    $insert_query = "INSERT INTO cliente 
                    (nombre, apellidoPaterno, apellidoMaterno, usuario, email, telefono, contrasena) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($insert_query);
    $stmt_insert->bind_param("sssssss", $nombre, $apellidoPaterno, $apellidoMaterno, $usuario, $email, $telefono, $hashed_password);

    if ($stmt_insert->execute()) {
        $_SESSION['success'] = "Registro exitoso. Ahora puedes iniciar sesión";
        header("Location: ../paginas/login_register/login.php");
    } else {
        $_SESSION['error'] = "Error al registrar: " . $conexion->error;
        header("Location: ../paginas/login_register/register.php");
    }

    // Cerrar conexiones
    $stmt_check->close();
    $stmt_insert->close();
    $conexion->close();
} else {
    // Si se accede directamente al script sin enviar formulario
    header("Location: ../../index.php");
    exit;
}
?>