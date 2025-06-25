<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Cafetería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('../../assets/images/cafe-background.jpg');
            background-size: cover;
            background-position: center;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .login-title {
            text-align: center;
            margin-bottom: 25px;
            color: #343a40;
            font-weight: 600;
        }
        .btn-login {
            width: 100%;
            padding: 10px;
            font-weight: 600;
            margin-top: 10px;
            background-color: #6f4e37;
            border: none;
        }
        .btn-login:hover {
            background-color: #5a3d2a;
        }
        .form-control {
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .alert {
            margin-bottom: 20px;
        }
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }
        .login-footer a {
            color: #6f4e37;
            text-decoration: none;
            font-weight: 500;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <form action="../../controladores/loginControl.php" method="post">
            <h1 class="login-title">Iniciar Sesión</h1>
            
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese su usuario" required>
            </div>
            
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-login btn-primary">Ingresar</button>
            </div>
            
            <div class="login-footer mt-3">
                <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
                <p><a href="../../index.php">Volver al inicio</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>