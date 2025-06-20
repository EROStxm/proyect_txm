<?php
session_start();
require_once '../controladores/conexion.php'; // Archivo de configuración de la DB

// Verificar si se envió el formulario
if (isset($_GET['enviar'])) {
    // Conexión a la base de datos
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Verificar errores de conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    // Escapar y limpiar datos de entrada
    $usuario = $conexion->real_escape_string(trim($_GET['names']));
    $password = trim($_GET['passw']);
    
    // Consulta preparada para evitar SQL Injection
    $sql = "SELECT idEmpleado, nombre, usuario, contraseña, rol FROM Empleado WHERE usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    // Verificar si el usuario existe
    if ($resultado->num_rows === 1) {
        $empleado = $resultado->fetch_assoc();
        
        // Verificar contraseña (hash)
        if (password_verify($password, $empleado['contraseña'])) {
            // Iniciar sesión
            $_SESSION['id_empleado'] = $empleado['idEmpleado'];
            $_SESSION['nombre'] = $empleado['nombre'];
            $_SESSION['rol'] = $empleado['rol'];
            $_SESSION['loggedin'] = true;
            
            // Redirigir según el rol
            switch ($empleado['rol']) {
                case 'Admin':
                    header("Location: ../vistas/admin/dashboard.php");
                    break;
                case 'Cajero':
                    header("Location: ../vistas/cajero/ventas.php");
                    break;
                case 'Inventario':
                    header("Location: ../vistas/inventario/gestion.php");
                    break;
                default:
                    header("Location: ../index.php");
            }
            exit;
        } else {
            // Contraseña incorrecta
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: ../paginas/login_register/login.php");
        }
    } else {
        // Usuario no existe
        $_SESSION['error'] = "Usuario no registrado";
        header("Location: ../paginas/login_register/login.php");
    }
    
    $stmt->close();
    $conexion->close();
} else {
    // Acceso directo al script
    header("Location: ../index.php");
}
?>