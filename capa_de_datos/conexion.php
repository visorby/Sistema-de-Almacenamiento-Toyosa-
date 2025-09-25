<?php
$host = "localhost";
$puerto = "3306";
$usuario = "root";
$contrasena = "";
$baseDeDatos = "bdalmacen";

// Evitar redeclaración de la función
if (!function_exists("Conectarse")) {
    function Conectarse()
    {
        global $host, $puerto, $usuario, $contrasena, $baseDeDatos;

        $link = mysqli_connect($host . ":" . $puerto, $usuario, $contrasena, $baseDeDatos);

        if (!$link) {
            die("Error conectando a la base de datos: " . mysqli_connect_error());
        }

        return $link;
    }
}

$link = Conectarse();
?>