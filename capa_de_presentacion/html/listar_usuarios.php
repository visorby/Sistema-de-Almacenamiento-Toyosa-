<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Almacen_de_Autos_Toyosa/capa_de_negocio/Modulo1/listar_usuarios.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios - Toyosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .badge-admin { background-color: #dc3545; }
        .badge-empleado { background-color: #fd7e14; }
        .badge-cliente { background-color: #20c997; }
        .table-hover tbody tr:hover { background-color: rgba(0,0,0,.075); }
    </style>
</head>
<body style="background-color:#ebdef0">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Lista de Usuarios Registrados - Toyosa</h3>
                        <div>
                            <a href="agregar_usuario.php" class="btn btn-success btn-sm">
                                <i class="bi bi-person-plus"></i> Nuevo Usuario
                            </a>
                            <a href="menu_principal.php" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-house"></i> Menú Principal
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        

                        <?php if (isset($_GET['mensaje'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($_GET['mensaje']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

  
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($usuarios)): ?>
                            <div class="alert alert-info text-center">
                                <h5>No hay usuarios registrados</h5>
                                <p>Comienza agregando el primer usuario al sistema.</p>
                                <a href="agregar_usuario.php" class="btn btn-primary">Agregar Primer Usuario</a>
                            </div>
                        <?php else: ?>
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body text-center">
                                            <h4><?php echo count($usuarios); ?></h4>
                                            <p class="mb-0">Total Usuarios</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-white bg-danger">
                                        <div class="card-body text-center">
                                            <h4><?php echo count(array_filter($usuarios, fn($u) => $u['tipos_usuario'] === 'administrador')); ?></h4>
                                            <p class="mb-0">Administradores</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-white bg-warning">
                                        <div class="card-body text-center">
                                            <h4><?php echo count(array_filter($usuarios, fn($u) => $u['tipos_usuario'] === 'empleado')); ?></h4>
                                            <p class="mb-0">Empleados</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-white bg-success">
                                        <div class="card-body text-center">
                                            <h4><?php echo count(array_filter($usuarios, fn($u) => $u['tipos_usuario'] === 'cliente')); ?></h4>
                                            <p class="mb-0">Clientes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID Usuario</th>
                                            <th>Cédula</th>
                                            <th>Alias</th>
                                            <th>Tipo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usuarios as $usuario): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($usuario['id_usuario']); ?></strong>
                                            </td>
                                            <td><?php echo htmlspecialchars($usuario['ci_usuario']); ?></td>
                                            <td><?php echo htmlspecialchars($usuario['alias_usuario']); ?></td>
                                            <td>
                                                <?php 
                                                $badge_class = [
                                                    'administrador' => 'badge-admin',
                                                    'empleado' => 'badge-empleado', 
                                                    'cliente' => 'badge-cliente'
                                                ][$usuario['tipos_usuario']] ?? 'badge-secondary';
                                                ?>
                                                <span class="badge <?php echo $badge_class; ?>">
                                                    <?php echo ucfirst(htmlspecialchars($usuario['tipos_usuario'])); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="editar_usuario.php?id=<?php echo urlencode($usuario['id_usuario']); ?>" 
                                                       class="btn btn-warning" title="Editar">
                                                       <i class="bi bi-pencil"></i> Editar
                                                    </a>
                                                    <a href="/Almacen_de_Autos_Toyosa/capa_de_negocio/Modulo1/eliminar_U.php?id=<?php echo $usuario['id_usuario']; ?>" 
                                                    class="btn btn-danger" 
                                                    onclick="return confirm('¿Está seguro de eliminar al usuario <?php echo $usuario['alias_usuario']; ?>?')">
                                                    Eliminar
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 text-muted">
                                <small>Mostrando <?php echo count($usuarios); ?> usuario(s) registrado(s)</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function confirmarEliminacion(idUsuario, aliasUsuario) {
            if (confirm(`¿Está seguro de eliminar al usuario "${aliasUsuario}"?\n\nEsta acción no se puede deshacer.`)) {
                    window.location.href = `listar_usuarios.php?eliminar_id=${idUsuario}`;
                }
            }
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>