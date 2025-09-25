<?php
include("../../capa_de_datos/conexion.php");

// Activar transacciones
mysqli_begin_transaction($link);

try {
    $id_proveedor = $_POST['id_proveedor'];
    $fecha = date("Y-m-d");

    // Insertar cabecera con total=0
    $sql = "INSERT INTO factura_proveedor (id_proveedor, fecha, total) 
            VALUES ('$id_proveedor', '$fecha', 0)";
    mysqli_query($link, $sql);

    // Obtener id_factura generado
    $id_factura = mysqli_insert_id($link);

    $totalFactura = 0;

    // Insertar detalles
    foreach ($_POST['items'] as $item) {
        $id_lote = $item['id_lote'];
        $cantidad = $item['cantidad'];
        $precio = $item['precio'];
        $subtotal = $cantidad * $precio;

        $sql = "INSERT INTO detalle_factura (id_factura, id_lote, cantidad, precio_unitario, subtotal) 
                VALUES ('$id_factura', '$id_lote', '$cantidad', '$precio', '$subtotal')";
        mysqli_query($link, $sql);

        $totalFactura += $subtotal;
    }

    // Actualizar total en la factura
    $sql = "UPDATE factura_proveedor SET total='$totalFactura' WHERE id_factura='$id_factura'";
    mysqli_query($link, $sql);

    // Confirmar cambios
    mysqli_commit($link);

    echo "Factura registrada con éxito. ID: $id_factura";
} catch (Exception $e) {
    mysqli_rollback($link);
    echo "Error al guardar la factura: " . $e->getMessage();
}
?>
