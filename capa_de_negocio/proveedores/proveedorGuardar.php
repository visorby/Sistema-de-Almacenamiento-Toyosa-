<?php
include("../../capa_de_datos/conexion.php");

// Verificamos si se presionó "Cancelar"
if (isset($_GET["Cancelar"])) {
    header("Location: ../../xframe/frameProveedores.php"); // redirige a la lista
    exit();
}

// Obtenemos valores del formulario
$modifica   = $_GET["modifica"];
$id         = $_GET["id"];
$razon      = $_GET["razon"];
$nombre     = $_GET["nombre"];
$representa = $_GET["representante"];
$telefono   = $_GET["telefono"];
$correo     = $_GET["correo"];
$tipo      = $_GET["tipo"];

// Guardar cambios
if (isset($_GET["Guardar"])) {
    if ($modifica == 0) {
        // INSERT
        $sql = "INSERT INTO proveedores 
                (id_proveedor, razon_social, nombre_empresa, representante_legal, telefono, correo, tipo) 
                VALUES 
                ('$id', '$razon', '$nombre', '$representa', '$telefono', '$correo', '$tipo')";
    } else {
        // UPDATE
        $sql = "UPDATE proveedores 
                SET razon_social='$razon',
                    nombre_empresa='$nombre',
                    representante_legal='$representa',
                    telefono='$telefono',
                    correo='$correo',
                    tipo='$tipo'
                WHERE id_proveedor='$id'";
    }

    if (mysqli_query($link, $sql)) {
        echo "<script>alert('Proveedor guardado correctamente'); window.location='../xframe/frameProveedores.php';</script>";
    } else {
        echo "Error: " . mysqli_error($link);
    }
}
?>
