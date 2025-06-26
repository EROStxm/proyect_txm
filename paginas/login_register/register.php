<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Cafetería TXM</title>
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
        .form-control::placeholder{
            color: white;
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
        
        .register-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--beige);
        }
        
        .register-footer a {
            color: var(--cafe-claro);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .register-footer a:hover {
            color: var(--beige);
            text-decoration: underline;
        }
        
        .password-strength {
            height: 5px;
            margin-top: -5px;
            margin-bottom: 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }
        
        .text-muted {
            color: var(--beige) !important;
            opacity: 0.7;
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
            
            <form id="registerForm" action="../../controladores/registroControl.php" method="post">
                <h1 class="register-title">Registro de Cliente</h1>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="apellidoPaterno" class="form-label required-field">Apellido Paterno</label>
                        <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" maxlength="50" placeholder="Registre su Apellido Paterno" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="apellidoMaterno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" maxlength="50" placeholder="Registre su Apellido Materno">
                    </div>
                </div>

                <div class="mb-3">
                        <label for="nombre" class="form-label required-field">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" placeholder="Registre su Nombre" required>
                </div>
                
                <div class="mb-3">
                    <label for="usuario" class="form-label required-field">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" maxlength="50" required>
                    <small class="text-muted">Este será tu nombre para iniciar sesión</small>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label required-field">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" maxlength="100" required>
                </div>
                
                <div class="mb-3">
                    <label for="telefono" class="form-label required-field">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="15" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label required-field">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrengthBar"></div>
                    </div>
                    <small id="passwordHelp" class="text-muted">Mínimo 8 caracteres</small>
                </div>
                
                <div class="mb-3">
                    <label for="confirm_password" class="form-label required-field">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn btn-register">Registrarse</button>
                
                <div class="register-footer">
                    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
                    <p><a href="../../index.php">← Volver al inicio</a></p>
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