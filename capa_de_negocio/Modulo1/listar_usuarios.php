<?php
require_once '../../capa_de_datos/conexion.php';


class ListarUsuarios {
    private $conexion;
    
    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }
    
    public function obtenerTodosLosUsuarios() {
        try {
            $sql = "SELECT id_usuario, ci_usuario, alias_usuario, tipos_usuario
                    FROM usuario 
                    ORDER BY id_usuario";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            throw new Exception("Error al obtener la lista de usuarios: " . $e->getMessage());
        }
    }
    
    public function obtenerUsuarioPorId($id_usuario) {
        try {
            $sql = "SELECT * FROM usuario WHERE id_usuario = :id_usuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el usuario: " . $e->getMessage());
        }
    }
}

try {
    $listarUsuarios = new ListarUsuarios();
    $usuarios = $listarUsuarios->obtenerTodosLosUsuarios();
    
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>