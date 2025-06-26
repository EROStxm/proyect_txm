<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = obtenerConexion();
    
    $usuario = $conexion->real_escape_string(trim($_POST['usuario']));
    $contrasena = trim($_POST['contrasena']);
    
    // Consulta para empleados
    $sql = "SELECT idEmpleado, nombre, apellidoPaterno, usuario, rol FROM empleado 
            WHERE usuario = ? AND contrasena = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows === 1) {
        $empleado = $resultado->fetch_assoc();
        
        // Configurar sesión
        $_SESSION['loggedin'] = true;
        $_SESSION['id_usuario'] = $empleado['idEmpleado'];
        $_SESSION['nombre'] = $empleado['nombre'] . ' ' . $empleado['apellidoPaterno'];
        $_SESSION['rol'] = $empleado['rol'];
        $_SESSION['tipo_usuario'] = 'empleado';
        
        // Redirigir según rol
        switch ($empleado['rol']) {
            case 'Admin':
                header('Location: ../../paginas/empleados/Admin.php');
                break;
            case 'Cajero':
                header('Location: ../../paginas/empleados/Cajero.php');
                break;
            case 'Inventario':
                header('Location: ../../paginas/empleados/Inventario.php');
                break;
            default:
                header('Location: ../../index.php');
        }
        exit;
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos";
        header('Location: ../../paginas/login_register/login.php');
        exit;
    }
    
    $stmt->close();
    $conexion->close();
} else {
    header('Location: ../../index.php');
    exit;
}
?>