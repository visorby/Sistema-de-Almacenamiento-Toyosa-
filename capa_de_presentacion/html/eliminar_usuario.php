<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Almacen_de_Autos_Toyosa/capa_de_negocio/Modulo1/eliminar_U.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario - Toyosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .card-eliminar {
            border: 2px solid #dc3545;
        }
        .card-header-eliminar {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }
        .usuario-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
        }
        .detalle-usuario {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        @media (max-width: 768px) {
            .detalle-usuario {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body style="background-color:#ebdef0">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-eliminar">
                    <div class="card-header card-header-eliminar text-center">
                        <h3 class="mb-0">Confirmar Eliminación de Usuario</h3>
                    </div>
                    <div class="card-body">
                        
                        <!-- Mensajes de error -->
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($usuario)): ?>
                        <div class="alert alert-warning">
                            <h5 class="alert-heading">¡Atención! Esta acción no se puede deshacer</h5>
                            <p class="mb-0">Está a punto de eliminar permanentemente un usuario del sistema.</p>
                        </div>

                        <!-- Información del usuario a eliminar -->
                        <div class="usuario-info">
                            <h5 class="text-center mb-3">Información del Usuario</h5>
                            <div class="detalle-usuario">
                                <div>
                                    <strong>ID Usuario:</strong><br>
                                    <span class="text-primary"><?php echo htmlspecialchars($usuario['id_usuario']); ?></span>
                                </div>
                                <div>
                                    <strong>Cédula:</strong><br>
                                    <?php echo htmlspecialchars($usuario['ci_usuario']); ?>
                                </div>
                                <div>
                                    <strong>Alias:</strong><br>
                                    <span class="text-info"><?php echo htmlspecialchars($usuario['alias_usuario']); ?></span>
                                </div>
                                <div>
                                    <strong>Tipo:</strong><br>
                                    <span class="badge bg-<?php 
                                        echo $usuario['tipos_usuario'] == 'administrador' ? 'danger' : 
                                             ($usuario['tipos_usuario'] == 'empleado' ? 'warning' : 'success'); 
                                    ?>">
                                        <?php echo ucfirst(htmlspecialchars($usuario['tipos_usuario'])); ?>
                                    </span>
                                </div>
                                <div>
                                    <strong>Fecha Registro:</strong><br>
                                    <?php 
                                    $fecha = new DateTime($usuario['fecha_creacion']);
                                    echo $fecha->format('d/m/Y H:i');
                                    ?>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="" id="formEliminar">
                            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                            
                            <div class="alert alert-danger">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirmacion" required>
                                    <label class="form-check-label" for="confirmacion">
                                        <strong>Confirmo que deseo eliminar permanentemente este usuario</strong>
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="listar_usuarios.php" class="btn btn-secondary me-md-2">
                                    <i class="bi bi-arrow-left"></i> Cancelar y Volver
                                </a>
                                <button type="submit" name="confirmar" class="btn btn-danger" id="btnEliminar" disabled>
                                    <i class="bi bi-trash"></i> Eliminar Permanentemente
                                </button>
                            </div>
                        </form>
                        <?php else: ?>
                            <div class="alert alert-warning text-center">
                                <h5>Usuario no encontrado</h5>
                                <p>El usuario que intentas eliminar no existe en el sistema.</p>
                                <a href="listar_usuarios.php" class="btn btn-primary">Volver a la lista</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('confirmacion');
            const btnEliminar = document.getElementById('btnEliminar');
            const formEliminar = document.getElementById('formEliminar');
            
            if (checkbox && btnEliminar) {
                checkbox.addEventListener('change', function() {
                    btnEliminar.disabled = !this.checked;
                });
            }
            
            if (formEliminar) {
                formEliminar.addEventListener('submit', function(e) {
                    if (!confirm('¿ESTÁ ABSOLUTAMENTE SEGURO?\n\nEsta acción eliminará permanentemente al usuario y no se podrá recuperar.')) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
            
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert.classList.contains('alert-dismissible')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 8000);
            });
        });
    </script>
</body>
</html>