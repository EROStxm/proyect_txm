<?php
session_start();
require_once '../controladores/conexion.php';

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
    $sql = "SELECT idEmpleado, nombre, usuario, contrasena, rol FROM Empleado WHERE usuario = ?";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }
    
    $stmt->bind_param("s", $usuario);
    
    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }
    
    $resultado = $stmt->get_result();
    
    // Verificar si el usuario existe
    if ($resultado->num_rows === 1) {
        $empleado = $resultado->fetch_assoc();
        
        // Verificar contraseña (hash)
        if ($password === $empleado['contrasena']) {
            // Iniciar sesión
            $_SESSION['id_empleado'] = $empleado['idEmpleado'];
            $_SESSION['nombre'] = $empleado['nombre'];
            $_SESSION['rol'] = $empleado['rol'];
            $_SESSION['loggedin'] = true;
            
            // Redirigir según el rol
            switch ($_SESSION['rol']) {
                case 'Admin':
                    header("Location: ../paginas/empleados/Admin.php");
                    break;
                case 'Cajero':
                    header("Location: ../paginas/empleados/Cajero.php");
                    break;
                case 'Inventario':
                    header("Location: ../paginas/empleados/Inventario.php");
                    break;
                default:
                    header("Location: ../paginas/clientes/productos.php");
            }
            exit;
        } else {
            // Contraseña incorrecta - CORRECCIÓN: Redirigir a login.php
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: ../paginas/login_register/login.php");
            exit;
        }
    } else {
        // Verificar si es un cliente
        $sql_cliente = "SELECT idCliente, nombre, usuario, contrasena FROM Cliente WHERE usuario = ?";
        $stmt_cliente = $conexion->prepare($sql_cliente);
        $stmt_cliente->bind_param("s", $usuario);
        $stmt_cliente->execute();
        $resultado_cliente = $stmt_cliente->get_result();
        
        if ($resultado_cliente->num_rows === 1) {
            $cliente = $resultado_cliente->fetch_assoc();
            if (password_verify($password, $cliente['contrasena'])) {
                $_SESSION['id_cliente'] = $cliente['idCliente'];
                $_SESSION['nombre'] = $cliente['nombre'];
                $_SESSION['loggedin'] = true;
                $_SESSION['rol'] = 'Cliente';
                header("Location: ../paginas/clientes/productos.php");
                exit;
            }
        }
        
        // Usuario no existe - CORRECCIÓN: Redirigir a login.php
        $_SESSION['error'] = "Usuario o contraseña incorrectos";
        header("Location: ../paginas/login_register/login.php");
        exit;
    }
    
    $stmt->close();
    if (isset($stmt_cliente)) {
        $stmt_cliente->close();
    }
    $conexion->close();
} else {
    // Acceso directo al script
    header("Location: ../../index.php");
    exit;
}
?>