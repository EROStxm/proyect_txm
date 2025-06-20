<?php
session_start();
require_once '../controladores/conexion.php';

if (isset($_GET['enviarf'])) {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // 1. Validación de datos
    $nombre = $conexion->real_escape_string(trim($_GET['nomb']));
    $usuario = $conexion->real_escape_string(trim($_GET['nick_usua']));
    $password = trim($_GET['clave_usua']);
    $confirm_password = trim($_GET['confirm_clave']);
    $email = $conexion->real_escape_string(trim($_GET['correo_usua']));
    $telefono = $conexion->real_escape_string(trim($_GET['telef_usua']));

    // 2. Validar contraseña
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Las contraseñas no coinciden";
        header("Location: ../paginas/login_register/register.php");
        exit;
    }

    if (strlen($password) < 8) {
        $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres";
        header("Location: ../paginas/login_register/register.php");
        exit;
    }

    // 3. Verificar unicidad (usuario/email)
    $check = $conexion->prepare("SELECT idEmpleado FROM Empleado WHERE usuario = ? OR email = ? UNION SELECT idCliente FROM Cliente WHERE usuario = ? OR email = ?");
    $check->bind_param("ssss", $usuario, $email, $usuario, $email);
    $check->execute();
    
    if ($check->get_result()->num_rows > 0) {
        $_SESSION['error'] = "El usuario o email ya están registrados";
        header("Location: ../paginas/login_register/register.php");
        exit;
    }

    // 4. Todos los nuevos registros son Clientes por defecto
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO Cliente (nombre, email, telefono, usuario, contraseña) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $email, $telefono, $usuario, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registro exitoso. Ahora puedes iniciar sesión";
        header("Location: ../paginas/login_register/login.php");
    } else {
        $_SESSION['error'] = "Error al registrar: " . $conexion->error;
        header("Location: ../paginas/login_register/register.php");
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: ../../index.php");
}
?>