<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal - Toyosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="menu_principal.php">
                🚗 Almacén de Autos Toyosa
            </a>
            
            <div class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> <?php echo $usuario['alias']; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><span class="dropdown-item-text">
                            Tipo: <span class="badge bg-<?php 
                                echo $usuario['tipo'] == 'administrador' ? 'danger' : 
                                     ($usuario['tipo'] == 'empleado' ? 'warning' : 'success'); 
                            ?>"><?php echo ucfirst($usuario['tipo']); ?></span>
                        </span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
                    </ul>
                </li>
            </div>
        </div>
    </nav>

    <div class="welcome-section">
        <div class="container text-center">
            <h1>Bienvenido, <?php echo $usuario['alias']; ?></h1>
            <p class="lead">Sistema de Gestión - Almacén de Autos Toyosa</p>
        </div>
    </div>

    <!-- Menú de Módulos -->
    <div class="container">
        <div class="row">
            
            <!-- Módulo de Usuarios (Solo para Administradores) -->
            <?php if ($usuario['tipo'] == 'administrador'): ?>
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Gestión de Usuarios</h5>
                        <p class="card-text">Administrar usuarios del sistema (solo administradores)</p>
                    </div>
                    <div class="card-footer">
                        <a href="listar_usuarios.php" class="btn btn-primary">Acceder</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Módulo de Inventario (Todos los usuarios) -->
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-car-front-fill" style="font-size: 2rem;"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Inventario de Autos</h5>
                        <p class="card-text">Gestionar el inventario de vehículos</p>
                    </div>
                    <div class="card-footer">
                        <a href="inventario.php" class="btn btn-success">Acceder</a>
                    </div>
                </div>
            </div>

            <!-- Módulo de Ventas (Empleados y Administradores) -->
            <?php if ($usuario['tipo'] == 'administrador' || $usuario['tipo'] == 'empleado'): ?>
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-header bg-warning text-white">
                        <i class="bi bi-cash-coin" style="font-size: 2rem;"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Gestión de Ventas</h5>
                        <p class="card-text">Registrar y gestionar ventas de vehículos</p>
                    </div>
                    <div class="card-footer">
                        <a href="ventas.php" class="btn btn-warning">Acceder</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Módulo de Reportes (Solo Administradores) -->
            <?php if ($usuario['tipo'] == 'administrador'): ?>
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-header bg-info text-white">
                        <i class="bi bi-graph-up" style="font-size: 2rem;"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Reportes</h5>
                        <p class="card-text">Generar reportes del sistema</p>
                    </div>
                    <div class="card-footer">
                        <a href="reportes.php" class="btn btn-info">Acceder</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Módulo de Perfil (Todos los usuarios) -->
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-header bg-secondary text-white">
                        <i class="bi bi-person" style="font-size: 2rem;"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Mi Perfil</h5>
                        <p class="card-text">Gestionar mi información personal</p>
                    </div>
                    <div class="card-footer">
                        <a href="perfil.php" class="btn btn-secondary">Acceder</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">Sistema de Gestión - Almacén de Autos Toyosa &copy; <?php echo date('Y'); ?></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>