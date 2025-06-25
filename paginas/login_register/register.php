<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente - Cafetería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            background-image: url('../../assets/images/cafe-background.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }
        .register-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
        }
        .register-title {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
            font-weight: 600;
        }
        .btn-register {
            width: 100%;
            padding: 12px;
            font-weight: 600;
            background-color: #6f4e37;
            border: none;
            margin-top: 15px;
        }
        .btn-register:hover {
            background-color: #5a3d2a;
        }
        .form-label {
            font-weight: 500;
        }
        .password-strength {
            height: 5px;
            margin-top: -10px;
            margin-bottom: 15px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }
        .login-link a {
            color: #6f4e37;
            text-decoration: none;
            font-weight: 500;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .form-control:focus {
            border-color: #6f4e37;
            box-shadow: 0 0 0 0.25rem rgba(111, 78, 55, 0.25);
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
            
            <form id="registerForm" action="../../controladores/registroControl.php" method="post">
                <h1 class="register-title">Registro de Cliente</h1>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="apellidoMaterno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" maxlength="50">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="apellidoPaterno" class="form-label">Apellido Paterno*</label>
                        <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" maxlength="50" required>
                    </div>
                </div>

                <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre*</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" required>
                </div>
                
                <div class="mb-3">
                    <label for="usuario" class="form-label">Nombre de Usuario*</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" maxlength="50" required>
                    <small class="text-muted">Este será tu nombre para iniciar sesión</small>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico*</label>
                    <input type="email" class="form-control" id="email" name="email" maxlength="100" required>
                </div>
                
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono*</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="15" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña*</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrengthBar"></div>
                    </div>
                    <small id="passwordHelp" class="text-muted">Mínimo 8 caracteres</small>
                </div>
                
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmar Contraseña*</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn btn-register">Registrarse</button>
                
                <div class="login-link">
                    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación de contraseña en tiempo real
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthBar = document.getElementById('passwordStrengthBar');
            let strength = 0;
            
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]/)) strength += 1;
            if (password.match(/[A-Z]/)) strength += 1;
            if (password.match(/[0-9]/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
            
            // Actualizar barra de fuerza
            const width = (strength / 5) * 100;
            strengthBar.style.width = width + '%';
            
            // Cambiar color según fuerza
            if (strength <= 2) {
                strengthBar.style.backgroundColor = '#dc3545';
            } else if (strength <= 4) {
                strengthBar.style.backgroundColor = '#ffc107';
            } else {
                strengthBar.style.backgroundColor = '#28a745';
            }
        });
        
        // Validación del formulario antes de enviar
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 8 caracteres');
                return false;
            }
            
            return true;
        });
    </script>
</body>
</html>