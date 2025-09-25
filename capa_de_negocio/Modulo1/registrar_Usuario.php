<?php
require_once '../../capa_de_datos/conexion.php';

class RegistrarUsuario {
    private $conexion;
    
    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }
    
    public function registrar($datosUsuario) {
        // Validar 
        if (empty($datosUsuario['id_usuario']) || empty($datosUsuario['ci_usuario']) || 
            empty($datosUsuario['alias_usuario']) || empty($datosUsuario['tipos_usuario']) ||
            empty($datosUsuario['contrasenia'])) {
            throw new Exception("Todos los campos obligatorios deben ser completados");
        }
        
        if (!is_numeric($datosUsuario['ci_usuario'])) {
            throw new Exception("El CI debe ser numérico");
        }
        
        if (strlen($datosUsuario['alias_usuario']) < 3) {
            throw new Exception("El alias debe tener al menos 3 caracteres");
        }
                
        if (strlen($datosUsuario['contrasenia']) < 6) {
            throw new Exception("La contraseña debe tener al menos 6 caracteres");
        }
        
        // Verificar id
        $sql_verificar_id = "SELECT id_usuario FROM usuario WHERE id_usuario = :id_usuario";
        $stmt_verificar_id = $this->conexion->prepare($sql_verificar_id);
        $stmt_verificar_id->bindParam(':id_usuario', $datosUsuario['id_usuario']);
        $stmt_verificar_id->execute();
        
        if ($stmt_verificar_id->fetch()) {
            throw new Exception("El ID de usuario ya existe en el sistema");
        }
        
        // Verificar ci
        $sql_verificar_ci = "SELECT id_usuario FROM usuario WHERE ci_usuario = :ci_usuario";
        $stmt_verificar_ci = $this->conexion->prepare($sql_verificar_ci);
        $stmt_verificar_ci->bindParam(':ci_usuario', $datosUsuario['ci_usuario']);
        $stmt_verificar_ci->execute();
        
        if ($stmt_verificar_ci->fetch()) {
            throw new Exception("El CI ya está registrado en el sistema");
        }
        
        // Verificar alias
        $sql_verificar_alias = "SELECT id_usuario FROM usuario WHERE alias_usuario = :alias_usuario";
        $stmt_verificar_alias = $this->conexion->prepare($sql_verificar_alias);
        $stmt_verificar_alias->bindParam(':alias_usuario', $datosUsuario['alias_usuario']);
        $stmt_verificar_alias->execute();
        
        if ($stmt_verificar_alias->fetch()) {
            throw new Exception("El alias de usuario ya está en uso");
        }
        
        // Encriptar contraseña
        $password_hash = password_hash($datosUsuario['contrasenia'], PASSWORD_DEFAULT);
        
        // Insertar usuario 
        $sql = "INSERT INTO usuario (id_usuario, ci_usuario, alias_usuario, tipos_usuario, contrasenia) 
                VALUES (:id_usuario, :ci_usuario, :alias_usuario, :tipos_usuario, :contrasenia)";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $datosUsuario['id_usuario']);
        $stmt->bindParam(':ci_usuario', $datosUsuario['ci_usuario']);
        $stmt->bindParam(':alias_usuario', $datosUsuario['alias_usuario']);
        $stmt->bindParam(':tipos_usuario', $datosUsuario['tipos_usuario']);
        $stmt->bindParam(':contrasenia', $password_hash);
        
        if ($stmt->execute()) {
            return "Usuario registrado exitosamente";
        } else {
            throw new Exception("Error al registrar el usuario en la base de datos");
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $registrarUsuario = new RegistrarUsuario();
        
        $datosUsuario = [
            'id_usuario' => $_POST['id_usuario'],
            'ci_usuario' => $_POST['ci_usuario'],
            'alias_usuario' => $_POST['alias_usuario'],
            'tipos_usuario' => $_POST['tipos_usuario'],
            'contrasenia' => $_POST['contrasenia']
        ];
        
        $resultado = $registrarUsuario->registrar($datosUsuario);
        $mensaje_exito = $resultado;
        
    } catch (Exception $e) {
        $mensaje_error = $e->getMessage();
    }
}
?>