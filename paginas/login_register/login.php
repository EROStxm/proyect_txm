<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Cafetería TXM</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: white;
            text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
            box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
        }
        
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            border: 1px solid var(--cafe-claro);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }
        
        .login-title {
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
            margin-bottom: 1.5rem;
        }
        
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: var(--cafe-medio);
            box-shadow: 0 0 0 0.25rem rgba(111, 78, 55, 0.25);
            color: white;
        }
        .form-control::placeholder{
            color: white;
        }
        .form-label {
            color: white;
            font-weight: 500;
        }
        
        .btn-login {
            width: 100%;
            padding: 10px;
            font-weight: 600;
            background-color: var(--cafe-medio);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background-color: var(--cafe-oscuro);
            transform: translateY(-2px);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--beige);
        }
        
        .login-footer a {
            color: var(--cafe-claro);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .login-footer a:hover {
            color: var(--beige);
            text-decoration: underline;
        }
        
        .alert {
            margin-bottom: 1.5rem;
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
                <button type="submit" class="btn btn-login">Ingresar</button>
            </div>
            
            <div class="login-footer mt-3">
                <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
                <p><a href="../../index.php">← Volver al inicio</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>