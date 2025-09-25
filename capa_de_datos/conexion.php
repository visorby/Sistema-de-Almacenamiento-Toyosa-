<?php
class Conexion {
    private $host = "localhost";
    private $dbname = "almacen_autos_toyosa";
    private $username = "root";
    private $password = "";
    private $conexion;
    
    public function conectar() {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}", 
                $this->username, 
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>