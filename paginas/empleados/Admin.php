<?php
require_once '../../controladores/auth_check.php';
if ($_SESSION['rol'] !== 'Admin') {
    header("Location: ../../paginas/clientes/productos.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    
</body>
<script>
    // Cerrar sesión después de 30 minutos de inactividad
    setTimeout(function() {
        window.location.href = '../paginas/login_register/login.php?timeout=1';
    }, 30 * 60 * 1000); // 30 minutos en milisegundos

    // Detectar actividad del usuario
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);

    function resetTimer() {
        clearTimeout(window.logoutTimer);
        window.logoutTimer = setTimeout(function() {
            window.location.href = '../paginas/login_register/login.php?timeout=1';
        }, 30 * 60 * 1000);
    }
</script>
</html>