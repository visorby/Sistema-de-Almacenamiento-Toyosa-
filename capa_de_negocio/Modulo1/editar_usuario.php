<?php
require_once '../../capa_de_datos/conexion.php';

class EditarUsuario {
    private $conexion;
    
    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }
    
    public function obtenerUsuarioPorId($id_usuario) {
        try {
            $sql = "SELECT id_usuario, ci_usuario, alias_usuario, tipos_usuario 
                    FROM usuario 
                    WHERE id_usuario = :id_usuario";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->execute();
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$usuario) {
                throw new Exception("Usuario no encontrado");
            }
            
            return $usuario;
            
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el usuario: " . $e->getMessage());
        }
    }
    
    public function actualizarUsuario($datosUsuario) {
        if (empty($datosUsuario['id_usuario']) || empty($datosUsuario['ci_usuario']) || 
            empty($datosUsuario['alias_usuario']) || empty($datosUsuario['tipos_usuario'])) {
            throw new Exception("Todos los campos obligatorios deben ser completados");
        }
        
        if (!is_numeric($datosUsuario['ci_usuario'])) {
            throw new Exception("El CI debe ser numérico");
        }
        
        if (strlen($datosUsuario['alias_usuario']) < 3) {
            throw new Exception("El alias debe tener al menos 3 caracteres");
        }
        

        $sql_verificar_ci = "SELECT id_usuario FROM usuario 
                            WHERE ci_usuario = :ci_usuario AND id_usuario != :id_usuario";
        $stmt_verificar_ci = $this->conexion->prepare($sql_verificar_ci);
        $stmt_verificar_ci->bindParam(':ci_usuario', $datosUsuario['ci_usuario']);
        $stmt_verificar_ci->bindParam(':id_usuario', $datosUsuario['id_usuario']);
        $stmt_verificar_ci->execute();
        
        if ($stmt_verificar_ci->fetch()) {
            throw new Exception("El CI ya está registrado por otro usuario");
        }
        

        $sql_verificar_alias = "SELECT id_usuario FROM usuario 
                               WHERE alias_usuario = :alias_usuario AND id_usuario != :id_usuario";
        $stmt_verificar_alias = $this->conexion->prepare($sql_verificar_alias);
        $stmt_verificar_alias->bindParam(':alias_usuario', $datosUsuario['alias_usuario']);
        $stmt_verificar_alias->bindParam(':id_usuario', $datosUsuario['id_usuario']);
        $stmt_verificar_alias->execute();
        
        if ($stmt_verificar_alias->fetch()) {
            throw new Exception("El alias ya está en uso por otro usuario");
        }
        

        $sql = "UPDATE usuario 
                SET ci_usuario = :ci_usuario, 
                    alias_usuario = :alias_usuario, 
                    tipos_usuario = :tipos_usuario 
                WHERE id_usuario = :id_usuario";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $datosUsuario['id_usuario']);
        $stmt->bindParam(':ci_usuario', $datosUsuario['ci_usuario']);
        $stmt->bindParam(':alias_usuario', $datosUsuario['alias_usuario']);
        $stmt->bindParam(':tipos_usuario', $datosUsuario['tipos_usuario']);
        
        if ($stmt->execute()) {
            return "Usuario actualizado exitosamente";
        } else {
            throw new Exception("Error al actualizar el usuario en la base de datos");
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $editarUsuario = new EditarUsuario();
        
        $datosUsuario = [
            'id_usuario' => $_POST['id_usuario'],
            'ci_usuario' => $_POST['ci_usuario'],
            'alias_usuario' => $_POST['alias_usuario'],
            'tipos_usuario' => $_POST['tipos_usuario']
        ];
        
        $resultado = $editarUsuario->actualizarUsuario($datosUsuario);
        $mensaje_exito = $resultado;
        
        header("Location: listar_usuarios.php?mensaje=" . urlencode($resultado));
        exit();
        
    } catch (Exception $e) {
        $mensaje_error = $e->getMessage();
    }
}

if (isset($_GET['id'])) {
    try {
        $editarUsuario = new EditarUsuario();
        $usuario = $editarUsuario->obtenerUsuarioPorId($_GET['id']);
        
    } catch (Exception $e) {
        $error = $e->getMessage();
        header("Location: listar_usuarios.php?error=" . urlencode($error));
        exit();
    }
} else {
    header("Location: listar_usuarios.php?error=ID de usuario no especificado");
    exit();
}
?>