<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Almacen_de_Autos_Toyosa/capa_de_negocio/Modulo1/editar_usuario.php';
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'administrador') {
    header("Location: menu_principal.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Toyosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body style="background-color:#ebdef0">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Editar Usuario - Toyosa</h3>
                    </div>
                    <div class="card-body">
                        
                        <?php if (isset($mensaje_error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($mensaje_error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($usuario)): ?>
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="id_usuario" class="form-label">ID Usuario *</label>
                                        <input type="text" class="form-control" id="id_usuario" name="id_usuario" 
                                               value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>" 
                                               readonly
                                               style="background-color: #e9ecef;">
                                        <div class="form-text">El ID de usuario no se puede modificar</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tipos_usuario" class="form-label">Tipo de Usuario *</label>
                                        <select class="form-select" id="tipos_usuario" name="tipos_usuario" required>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="administrador" <?php echo $usuario['tipos_usuario'] == 'administrador' ? 'selected' : ''; ?>>Administrador</option>
                                            <option value="empleado" <?php echo $usuario['tipos_usuario'] == 'empleado' ? 'selected' : ''; ?>>Empleado</option>
                                            <option value="cliente" <?php echo $usuario['tipos_usuario'] == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ci_usuario" class="form-label">Cédula de Identidad *</label>
                                        <input type="number" class="form-control" id="ci_usuario" name="ci_usuario" 
                                               value="<?php echo htmlspecialchars($usuario['ci_usuario']); ?>" required
                                               placeholder="Ej: 1234567">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alias_usuario" class="form-label">Alias de Usuario *</label>
                                        <input type="text" class="form-control" id="alias_usuario" name="alias_usuario" 
                                               value="<?php echo htmlspecialchars($usuario['alias_usuario']); ?>" required
                                               placeholder="Ej: juan.perez">
                                        <div class="form-text">Mínimo 3 caracteres</div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <h6 class="alert-heading">Información importante</h6>
                                <p class="mb-0">Solo se pueden modificar los datos básicos del usuario. La contraseña debe ser restablecida desde la opción correspondiente.</p>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="listar_usuarios.php" class="btn btn-secondary me-md-2">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                            </div>
                        </form>
                        <?php else: ?>
                            <div class="alert alert-warning text-center">
                                <h5>Usuario no encontrado</h5>
                                <p>El usuario que intentas editar no existe en el sistema.</p>
                                <a href="listar_usuarios.php" class="btn btn-primary">Volver a la lista</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/validaciones_editar.js"></script>
</body>
</html>