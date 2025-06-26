<?php
require_once '../../controladores/verificar_autenticacion.php';
?>
<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administración - TXM</title>
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
            background-image: url('../assets/images/cafe-background.jpg');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
            color: white;
            text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
            box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
        }
        
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .sidebar {
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 1.5rem;
            height: 100%;
            border: 1px solid var(--cafe-claro);
        }
        
        .sidebar .nav-link {
            color: var(--beige);
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            background-color: var(--cafe-medio);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 2rem;
            border: 1px solid var(--cafe-claro);
        }
        
        .card-admin {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--cafe-claro);
            border-radius: 10px;
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .card-admin:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        
        .card-admin .card-body {
            padding: 1.5rem;
        }
        
        .card-admin .card-title {
            color: var(--beige);
            font-weight: 600;
        }
        
        .card-admin .card-text {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .btn-admin {
            background-color: var(--cafe-medio);
            border: none;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-admin:hover {
            background-color: var(--cafe-oscuro);
            color: white;
        }
        
        .table-admin {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .table-admin th {
            background-color: var(--cafe-medio);
            color: white;
            border-color: var(--cafe-claro);
        }
        
        .table-admin td {
            border-color: var(--cafe-claro);
            vertical-align: middle;
        }
        
        .header-admin {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 1rem 0;
            border-bottom: 1px solid var(--cafe-claro);
            margin-bottom: 2rem;
        }
        
        .user-dropdown .dropdown-menu {
            background-color: rgba(0, 0, 0, 0.9);
            border: 1px solid var(--cafe-claro);
        }
        
        .user-dropdown .dropdown-item {
            color: var(--beige);
        }
        
        .user-dropdown .dropdown-item:hover {
            background-color: var(--cafe-medio);
            color: white;
        }
        
        .stat-card {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            padding: 1.5rem;
            border-left: 5px solid var(--cafe-medio);
            margin-bottom: 1.5rem;
        }
        
        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--beige);
        }
        
        .stat-card .stat-label {
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
    </style>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column h-100">    
     <!-- Header -->
    <header class="header-admin">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-cup-hot-fill"></i> Cafetería TXM - Panel de Administración
                </h3>
                <div class="user-dropdown">
                    <div class="dropdown">
                        <button class="btn btn-admin dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($nombre_usuario); ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><span class="dropdown-item disabled"><i class="bi bi-person-badge"></i> <?php echo htmlspecialchars($rol_usuario); ?></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../../controladores/cerrar_sesion.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-shrink-0 admin-container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="sidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-people"></i> Usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-cup-straw"></i> Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-cash-coin"></i> Ventas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-box-seam"></i> Inventario
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-truck"></i> Proveedores
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-graph-up"></i> Reportes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-gear"></i> Configuración
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="col-lg-9">
                <div class="main-content">
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-value">1,024</div>
                                <div class="stat-label">Ventas Hoy</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-value">$24,560</div>
                                <div class="stat-label">Ingresos</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-value">56</div>
                                <div class="stat-label">Productos Bajos</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-value">128</div>
                                <div class="stat-label">Clientes Nuevos</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <h4 class="mb-3 text-beige"><i class="bi bi-lightning"></i> Acciones Rápidas</h4>
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="card card-admin">
                                <div class="card-body text-center">
                                    <i class="bi bi-plus-circle" style="font-size: 2rem; color: var(--beige);"></i>
                                    <h5 class="card-title mt-2">Agregar Producto</h5>
                                    <p class="card-text">Añade un nuevo producto al menú</p>
                                    <a href="#" class="btn btn-admin">Ir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card card-admin">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-plus" style="font-size: 2rem; color: var(--beige);"></i>
                                    <h5 class="card-title mt-2">Registrar Nuevo Empleado</h5>
                                    <p class="card-text">Registrar un Nuevo Empleado</p>
                                    <a href="registrar_empleado.php" class="btn btn-admin">Ir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card card-admin">
                                <div class="card-body text-center">
                                    <i class="bi bi-cash-stack" style="font-size: 2rem; color: var(--beige);"></i>
                                    <h5 class="card-title mt-2">Registrar Venta</h5>
                                    <p class="card-text">Registra una nueva venta manual</p>
                                    <a href="#" class="btn btn-admin">Ir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card card-admin">
                                <div class="card-body text-center">
                                    <i class="bi bi-box-seam" style="font-size: 2rem; color: var(--beige);"></i>
                                    <h5 class="card-title mt-2">Actualizar Inventario</h5>
                                    <p class="card-text">Realiza ajustes al inventario</p>
                                    <a href="#" class="btn btn-admin">Ir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Orders -->
                    <h4 class="mb-3 text-beige"><i class="bi bi-clock-history"></i> Ventas Recientes</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-admin">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#1001</td>
                                    <td>Juan Pérez</td>
                                    <td>2023-06-15 10:30</td>
                                    <td>$45.50</td>
                                    <td><span class="badge bg-success">Completado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-admin"><i class="bi bi-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#1000</td>
                                    <td>María García</td>
                                    <td>2023-06-15 09:15</td>
                                    <td>$32.75</td>
                                    <td><span class="badge bg-success">Completado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-admin"><i class="bi bi-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#999</td>
                                    <td>Carlos López</td>
                                    <td>2023-06-14 16:45</td>
                                    <td>$28.90</td>
                                    <td><span class="badge bg-success">Completado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-admin"><i class="bi bi-eye"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Low Stock Products -->
                    <h4 class="mb-3 text-beige"><i class="bi bi-exclamation-triangle"></i> Productos con Bajo Stock</h4>
                    <div class="table-responsive">
                        <table class="table table-admin">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Stock Actual</th>
                                    <th>Stock Mínimo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Café Especial</td>
                                    <td>Bebidas</td>
                                    <td>3</td>
                                    <td>10</td>
                                    <td>
                                        <button class="btn btn-sm btn-admin"><i class="bi bi-plus-circle"></i> Reabastecer</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Croissant</td>
                                    <td>Panadería</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>
                                        <button class="btn btn-sm btn-admin"><i class="bi bi-plus-circle"></i> Reabastecer</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-dark text-center">
        <div class="container">
            <span class="text-muted">© 2023 Cafetería TXM - Sistema de Administración</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>