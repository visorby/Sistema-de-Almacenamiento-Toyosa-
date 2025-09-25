<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Almacen_de_Autos_Toyosa/capa_de_negocio/Modulo1/registrar_Usuario.php';
session_start();


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario - Toyosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body style="background-color:#ebdef0">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Agregar Nuevo Usuario - Toyosa</h3>
                    </div>
                    <div class="card-body">
                        
                        <?php if (isset($mensaje_exito)): ?>
                            <div class="alert alert-success"><?php echo $mensaje_exito; ?></div>
                        <?php endif; ?>
                        
                        <?php if (isset($mensaje_error)): ?>
                            <div class="alert alert-danger"><?php echo $mensaje_error; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="id_usuario" class="form-label">ID Usuario *</label>
                                        <input type="text" class="form-control" id="id_usuario" name="id_usuario" 
                                               value="<?php echo $_POST['id_usuario'] ?? ''; ?>" required
                                               placeholder="Ej: USU001">
                                        <div class="form-text">Identificador único del usuario</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tipos_usuario" class="form-label">Tipo de Usuario *</label>
                                        <select class="form-select" id="tipos_usuario" name="tipos_usuario" required>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="administrador" <?php echo ($_POST['tipos_usuario'] ?? '') == 'administrador' ? 'selected' : ''; ?>>Administrador</option>
                                            <option value="empleado" <?php echo ($_POST['tipos_usuario'] ?? '') == 'empleado' ? 'selected' : ''; ?>>Empleado</option>
                                            <option value="cliente" <?php echo ($_POST['tipos_usuario'] ?? '') == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ci_usuario" class="form-label">Cédula de Identidad *</label>
                                        <input type="number" class="form-control" id="ci_usuario" name="ci_usuario" 
                                               value="<?php echo $_POST['ci_usuario'] ?? ''; ?>" required
                                               placeholder="Ej: 9111556">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alias_usuario" class="form-label">Alias de Usuario *</label>
                                        <input type="text" class="form-control" id="alias_usuario" name="alias_usuario" 
                                               value="<?php echo $_POST['alias_usuario'] ?? ''; ?>" required
                                               placeholder="Ej: admin">
                                        <div class="form-text">Mínimo 3 caracteres</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="contrasenia" class="form-label">Contraseña *</label>
                                <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
                                <div class="form-text">Mínimo 6 caracteres</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                                <a href="listar_usuarios.php" class="btn btn-secondary">Ver Lista de Usuarios</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/validaciones.js"></script>
</body>
</html>