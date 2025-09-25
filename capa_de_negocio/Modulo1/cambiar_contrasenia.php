<?php
require_once '../../capa_de_datos/conexion.php';

class CambiarContrasenia {
    private $conexion;
    
    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }
    
    public function cambiarPassword($id_usuario, $nueva_password) {
        if (strlen($nueva_password) < 6) {
            throw new Exception("La contraseña debe tener al menos 6 caracteres");
        }
        
        $password_hash = password_hash($nueva_password, PASSWORD_DEFAULT);
        
        $sql = "UPDATE usuario SET contrasenia = :contrasenia WHERE id_usuario = :id_usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':contrasenia', $password_hash);
        $stmt->bindParam(':id_usuario', $id_usuario);
        
        if ($stmt->execute()) {
            return "Contraseña actualizada exitosamente";
        } else {
            throw new Exception("Error al actualizar la contraseña");
        }
    }
}
?>