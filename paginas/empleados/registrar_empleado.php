<?php
require_once '../../controladores/verificar_autenticacion.php';

// Verificar que solo el Admin pueda acceder
if ($_SESSION['rol'] !== 'Admin') {
    header('Location: Admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empleado - Cafetería TXM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --cafe-oscuro: #5a3d2a;
            --cafe-medio: #6f4e37;
            --cafe-claro: #8b6b4a;
            --beige: #e6d5c3;
            --texto-oscuro: #343a40;
        }
        
        body {
            background-color: var(--texto-oscuro);
            background-image: url('../../assets/images/cafe-background.jpg');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
            min-height: 100vh;
            color: white;
            text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
            box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
        }
        
        .register-container {
            max-width: 600px;
            width: 100%;
            padding: 2rem;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            border: 1px solid var(--cafe-claro);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            margin: 2rem auto;
        }
        
        .register-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--beige);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--cafe-claro);
            color: white;
            margin-bottom: 1rem;
        }
        
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: var(--cafe-medio);
            box-shadow: 0 0 0 0.25rem rgba(111, 78, 55, 0.25);
            color: white;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .form-label {
            color: var(--beige);
            font-weight: 500;
        }
        
        .btn-register {
            width: 100%;
            padding: 10px;
            font-weight: 600;
            background-color: var(--cafe-medio);
            border: none;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        
        .btn-register:hover {
            background-color: var(--cafe-oscuro);
            transform: translateY(-2px);
        }
        
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <form id="registerForm" action="../../controladores/registrar_empleado.php" method="post">
                <h1 class="register-title">Registrar Nuevo Empleado</h1>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label required-field">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" placeholder="Ingrese el nombre" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="apellidoPaterno" class="form-label required-field">Apellido Paterno</label>
                        <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" maxlength="50" placeholder="Ingrese apellido paterno" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="apellidoMaterno" class="form-label">Apellido Materno</label>
                    <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" maxlength="50" placeholder="Ingrese apellido materno (opcional)">
                </div>
                
                <div class="mb-3">
                    <label for="usuario" class="form-label required-field">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" maxlength="50" placeholder="Crear nombre de usuario" required>
                    <small class="text-muted">Este será el nombre para iniciar sesión</small>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label required-field">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" maxlength="100" placeholder="Ingrese correo electrónico" required>
                </div>
                
                <div class="mb-3">
                    <label for="telefono" class="form-label required-field">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="15" placeholder="Ingrese número telefónico" required>
                </div>
                
                <div class="mb-3">
                    <label for="contrasena" class="form-label required-field">Contraseña Temporal</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Establezca una contraseña temporal" required>
                    <small class="text-muted">El empleado deberá cambiar esta contraseña al primer ingreso</small>
                </div>
                
                <div class="mb-3">
                    <label for="rol" class="form-label required-field">Rol del Empleado</label>
                    <select class="form-select" id="rol" name="rol" required>
                        <option value="" selected disabled>Seleccione un rol</option>
                        <option value="Admin">Administrador</option>
                        <option value="Cajero">Cajero</option>
                        <option value="Inventario">Inventario</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-register">Registrar Empleado</button>
                
                <div class="text-center mt-3">
                    <a href="Admin.php" class="btn btn-outline-secondary">Volver al Panel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>