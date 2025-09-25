<?php
require_once '../../capa_de_datos/conexion.php';

class EliminarUsuario {
    private $conexion;
    
    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }
    
    public function eliminarUsuario($id_usuario) {
        if (empty($id_usuario)) {
            throw new Exception("ID de usuario no especificado");
        }
        

        $sql_verificar = "SELECT id_usuario, alias_usuario FROM usuario WHERE id_usuario = :id_usuario";
        $stmt_verificar = $this->conexion->prepare($sql_verificar);
        $stmt_verificar->bindParam(':id_usuario', $id_usuario);
        $stmt_verificar->execute();
        
        $usuario = $stmt_verificar->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuario) {
            throw new Exception("El usuario no existe en el sistema");
        }
        

        $sql = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        
        if ($stmt->execute()) {
            return "Usuario '{$usuario['alias_usuario']}' eliminado exitosamente";
        } else {
            throw new Exception("Error al eliminar el usuario de la base de datos");
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $eliminarUsuario = new EliminarUsuario();
        $id_usuario = $_GET['id'];
        
        $mensaje = $eliminarUsuario->eliminarUsuario($id_usuario);
        

        header("Location: /Almacen_de_Autos_Toyosa/capa_de_presentacion/html/listar_usuarios.php?mensaje=" . urlencode($mensaje));
        exit();
        
    } catch (Exception $e) {

        header("Location: ../capa_de_presentacion/html/listar_usuarios.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>