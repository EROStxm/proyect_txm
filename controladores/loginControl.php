<?php
session_start();
require_once '../controladores/conexion.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Verificar errores de conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    // Obtener y limpiar datos
    $usuario = trim($conexion->real_escape_string($_POST['usuario']));
    $contrasena = $_POST['contrasena'];
    
    // Primero verificar si es empleado
    $sql_empleado = "SELECT idEmpleado, nombre, apellidoPaterno, usuario, contrasena, rol 
                    FROM empleado 
                    WHERE usuario = ?";
    $stmt_empleado = $conexion->prepare($sql_empleado);
    $stmt_empleado->bind_param("s", $usuario);
    $stmt_empleado->execute();
    $result_empleado = $stmt_empleado->get_result();
    
    if ($result_empleado->num_rows === 1) {
        $empleado = $result_empleado->fetch_assoc();
        
        // Verificar contraseña (sin hash en este caso según tu DB)
        if ($contrasena === $empleado['contrasena']) {
            // Configurar sesión de empleado
            $_SESSION['user_id'] = $empleado['idEmpleado'];
            $_SESSION['nombre'] = $empleado['nombre'] . ' ' . $empleado['apellidoPaterno'];
            $_SESSION['rol'] = $empleado['rol'];
            $_SESSION['loggedin'] = true;
            $_SESSION['tipo_usuario'] = 'empleado';
            
            // Redirigir según rol
            switch ($empleado['rol']) {
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
                    header("Location: ../index.php");
            }
            exit;
        }
    }
    
    // Si no es empleado, verificar si es cliente
    $sql_cliente = "SELECT idCliente, nombre, apellidoPaterno, usuario, contrasena 
                   FROM cliente 
                   WHERE usuario = ?";
    $stmt_cliente = $conexion->prepare($sql_cliente);
    $stmt_cliente->bind_param("s", $usuario);
    $stmt_cliente->execute();
    $result_cliente = $stmt_cliente->get_result();
    
    if ($result_cliente->num_rows === 1) {
        $cliente = $result_cliente->fetch_assoc();
        
        // Verificar contraseña (sin hash en este caso según tu DB)
        if ($contrasena === $cliente['contrasena']) {
            // Configurar sesión de cliente
            $_SESSION['user_id'] = $cliente['idCliente'];
            $_SESSION['nombre'] = $cliente['nombre'] . ' ' . $cliente['apellidoPaterno'];
            $_SESSION['rol'] = 'Cliente';
            $_SESSION['loggedin'] = true;
            $_SESSION['tipo_usuario'] = 'cliente';
            
            header("Location: ../paginas/clientes/productos.php");
            exit;
        }
    }
    
    // Si llegamos aquí, las credenciales son incorrectas
    $_SESSION['error'] = "Usuario o contraseña incorrectos";
    header("Location: ../paginas/login_register/login.php");
    exit;
    
    // Cerrar conexiones
    $stmt_empleado->close();
    $stmt_cliente->close();
    $conexion->close();
} else {
    // Si se accede directamente al script sin enviar formulario
    header("Location: ../index.php");
    exit;
}
?>