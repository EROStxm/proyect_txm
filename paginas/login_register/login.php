<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
			align-content: center;
			justify-items: center;
            min-height: 100vh;
			
        }
		.container{
			display: flex;
            justify-content: center;
            align-items: center;
			align-content: center;
			justify-items: center;
			background-color: rgba(0,0,0,0);
		}
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background-color: rgba(255,255,255,0.8);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .login-title {
            text-align: center;
            margin-bottom: 25px;
            color: #343a40;
        }
        .btn-login {
            width: 100%;
            padding: 10px;
            font-weight: 600;
            margin-top: 10px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        .form-control {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?>xd</div>
            <?php endif; ?>
            <form id="registro" action="../../controladores/loginControl.php" method="get">
                <h1 class="login-title">Inicio de Sesión</h1>
                <div class="mb-3">
                    <label for="names" class="form-label">Nick de Usuario</label>
                    <input type="text" class="form-control" id="names" name="names" placeholder="Nick de usuario" required>
                </div>
                
                <div class="mb-3">
                    <label for="passw" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="passw" name="passw" placeholder="Contrasena" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-login" name="enviar" value="Aceptar">Ingresar</button>
                
                <div class="register-link mt-3">
                    <p class="text-muted"><a href="../../index.php" class="text-decoration-none">Volver </a>¿No está registrado? <a href="register.php" class="text-decoration-none">Registrarse</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>