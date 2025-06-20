<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }
        .btn-register {
            width: 100%;
            padding: 10px;
            font-weight: 600;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            
            <form action="../../controladores/registroControl.php" method="get">
                <h1 class="form-title mb-4">Formulario de Registro</h1>
                
                <div class="mb-3">
                    <label for="nomb" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nomb" name="nomb" placeholder="Su Nombre por favor" required>
                </div>

                <div class="mb-3">
                    <label for="nick_usua" class="form-label">Nick Usuario</label>
                    <input type="text" class="form-control" id="nick_usua" name="nick_usua" placeholder="Su Nick por favor" required>
                </div>
                
                <div class="mb-3">
                    <label for="clave_usua" class="form-label">Clave Usuario</label>
                    <input type="password" class="form-control" id="clave_usua" name="clave_usua" placeholder="Contraseña" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_clave" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="confirm_clave" name="confirm_clave" required>
                </div>
                <div class="mb-3">
                    <label for="correo_usua" class="form-label">Correo Usuario</label>
                    <input type="email" class="form-control" id="correo_usua" name="correo_usua" placeholder="Su Correo por favor" required>
                </div>
                
                <div class="mb-3">
                    <label for="telef_usua" class="form-label">Teléfono Usuario</label>
                    <input type="tel" class="form-control" id="telef_usua" name="telef_usua" placeholder="Su Teléfono por favor" required>
                </div>                
                
                <button type="submit" class="btn btn-primary btn-register" name="enviarf" value="Aceptar">Registrar</button>
                
                <div class="login-link mt-3">
                    <p class="text-muted">¿Ya cuenta con un registro? <a href="login.php" class="text-decoration-none">Iniciar sesión</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>