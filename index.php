<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: capa_de_presentacion/html/menu_principal.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alias = $_POST['alias_usuario'] ?? '';
    $contrasenia = $_POST['contrasenia'] ?? '';
    
    if (!empty($alias) && !empty($contrasenia)) {
        try {
            require_once 'capa_de_datos/conexion.php';
            
            $db = new Conexion();
            $conexion = $db->conectar();
            
            $sql = "SELECT id_usuario, alias_usuario, contrasenia, tipos_usuario 
                    FROM usuario 
                    WHERE alias_usuario = :alias_usuario";
            
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':alias_usuario', $alias);
            $stmt->execute();
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario && password_verify($contrasenia, $usuario['contrasenia'])) {

                $_SESSION['usuario'] = [
                    'id' => $usuario['id_usuario'],
                    'alias' => $usuario['alias_usuario'],
                    'tipo' => $usuario['tipos_usuario']
                ];
                
                header("Location: capa_de_presentacion/html/menu_principal.php");
                exit();
            } else {
                $error = "Alias o contraseña incorrectos";
            }
            
        } catch (Exception $e) {
            $error = "Error en el sistema: " . $e->getMessage();
        }
    } else {
        $error = "Por favor complete todos los campos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacén de Autos Toyosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo h2 {
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card p-5">
                    <div class="logo">
                        <h2>Toyosa</h2>
                        <p class="text-muted">Almacén de Autos</p>
                    </div>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="alias_usuario" class="form-label">Alias</label>
                            <input type="text" class="form-control" id="alias_usuario" name="alias_usuario" 
                                   value="<?php echo $_POST['alias_usuario'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contrasenia" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2">Iniciar Sesión</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">Sistema de Gestión - Almacén de Autos Toyosa - GRUPO 2 TAW (2025)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>