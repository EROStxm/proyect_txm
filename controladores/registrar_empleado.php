<?php
session_start();
require_once 'conexion.php';
require_once 'verificar_autenticacion.php';

// Verificar que solo el Admin pueda registrar empleados
if ($_SESSION['rol'] !== 'Admin') {
    $_SESSION['error'] = "No tienes permisos para realizar esta acción";
    header('Location: ../paginas/empleados/Admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = obtenerConexion();
    
    // Obtener y sanitizar datos
    $nombre = $conexion->real_escape_string(trim($_POST['nombre']));
    $apellidoPaterno = $conexion->real_escape_string(trim($_POST['apellidoPaterno']));
    $apellidoMaterno = isset($_POST['apellidoMaterno']) ? $conexion->real_escape_string(trim($_POST['apellidoMaterno'])) : null;
    $usuario = $conexion->real_escape_string(trim($_POST['usuario']));
    $email = $conexion->real_escape_string(trim($_POST['email']));
    $telefono = $conexion->real_escape_string(trim($_POST['telefono']));
    $contrasena = trim($_POST['contrasena']);
    $rol = $conexion->real_escape_string($_POST['rol']);

    // Validaciones básicas
    $errors = [];
    
    if (empty($nombre) || empty($apellidoPaterno) || empty($usuario) || 
        empty($email) || empty($telefono) || empty($contrasena) || empty($rol)) {
        $errors[] = "Todos los campos obligatorios deben ser completados";
    }
    
    if (strlen($nombre) > 50 || strlen($apellidoPaterno) > 50 || 
        (isset($apellidoMaterno) && strlen($apellidoMaterno) > 50)) {
        $errors[] = "Los nombres y apellidos no deben exceder los 50 caracteres";
    }
    
    if (strlen($contrasena) < 8) {
        $errors[] = "La contraseña debe tener al menos 8 caracteres";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El formato del correo electrónico no es válido";
    }

    // Verificar si el usuario, email o teléfono ya existen
    $check_query = "SELECT idEmpleado FROM empleado WHERE usuario = ? OR email = ? OR telefono = ?";
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
        header("Location: ../paginas/empleados/registrar_empleado.php");
        exit;
    }

    // Hash de la contraseña
    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar nuevo empleado
    $insert_query = "INSERT INTO empleado 
                    (nombre, apellidoPaterno, apellidoMaterno, usuario, email, telefono, contrasena, rol) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($insert_query);
    $stmt_insert->bind_param("ssssssss", $nombre, $apellidoPaterno, $apellidoMaterno, 
                            $usuario, $email, $telefono, $hashed_password, $rol);

    if ($stmt_insert->execute()) {
        $_SESSION['success'] = "Empleado registrado exitosamente";
        header("Location: ../paginas/empleados/Admin.php");
    } else {
        $_SESSION['error'] = "Error al registrar empleado: " . $conexion->error;
        header("Location: ../paginas/empleados/registrar_empleado.php");
    }

    // Cerrar conexiones
    $stmt_check->close();
    $stmt_insert->close();
    $conexion->close();
} else {
    // Si se accede directamente al script sin enviar formulario
    header("Location: ../index.php");
    exit;
}
?>