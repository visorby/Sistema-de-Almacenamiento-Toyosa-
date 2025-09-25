<?php
include("../../capa_de_datos/conexion.php");

$id_lote = $_POST['id_lote'];
$id_proveedor = $_POST['id_proveedor'];
$tipo = $_POST['tipo'];
$precio = $_POST['precio'];

$fecha = date("Y-m-d");

// Traer datos del lote
$sql = "SELECT cantidad FROM lotes WHERE id_lote='$id_lote'";
$res = mysqli_query($link, $sql);
$lote = mysqli_fetch_assoc($res);

$cantidad = $lote['cantidad'];
$subtotal = $cantidad * $precio;

// Generar un ID de factura único (ej: FAC004)
$resFac = mysqli_query($link, "SELECT MAX(id_factura) as ultimo FROM factura_proveedor");
$rowFac = mysqli_fetch_assoc($resFac);
$ultimo = $rowFac['ultimo'];
$num = intval(substr($ultimo, 3)) + 1;
$id_factura = "FAC" . str_pad($num, 3, "0", STR_PAD_LEFT);

// Insertar en factura_proveedor
mysqli_query($link, "INSERT INTO factura_proveedor (id_factura, id_proveedor, Fecha, Tipo, MontoTotal, Estado)
                     VALUES ('$id_factura', '$id_proveedor', '$fecha', '$tipo', '$subtotal', 'Emitida')");

// Insertar detalle_factura
$id_detalle = uniqid("DET"); // genera algo como DET6529ab
mysqli_query($link, "INSERT INTO detalle_factura (id_detalle, id_factura, id_lote, cantidad, precio_unitario, subtotal)
                     VALUES ('$id_detalle', '$id_factura', '$id_lote', '$cantidad', '$precio', '$subtotal')");

// Actualizar lote con id_factura
mysqli_query($link, "UPDATE lotes SET id_factura='$id_factura' WHERE id_lote='$id_lote'");

// Redirigir a detalle de factura
header("Location: detalleFactura.php?id_factura=$id_factura");
exit;
?>
