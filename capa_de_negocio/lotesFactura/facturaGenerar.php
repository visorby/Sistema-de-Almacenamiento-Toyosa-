<?php
include("../../capa_de_datos/conexion.php");

if (!isset($_GET['id_lote'])) {
    die("Error: Falta id_lote");
}
$id_lote = $_GET['id_lote'];

// Traer datos del lote y proveedor
$sql = "SELECT l.id_lote, l.cantidad, l.tipo, p.id_proveedor, p.razon_social, p.nit
        FROM lotes l
        JOIN proveedores p ON l.id_proveedor = p.id_proveedor
        WHERE l.id_lote='$id_lote'";
$res = mysqli_query($link, $sql);
$lote = mysqli_fetch_assoc($res);
?>
<html>
<head><meta charset="UTF-8"><title>Generar Factura</title></head>
<body>
<h2>Generar Factura</h2>

<p><b>Lote:</b> <?php echo $lote['id_lote']; ?> (<?php echo $lote['tipo']; ?>)</p>
<p><b>Proveedor:</b> <?php echo $lote['razon_social']; ?> (NIT: <?php echo $lote['nit']; ?>)</p>
<p><b>Cantidad:</b> <?php echo $lote['cantidad']; ?></p>

<form action="procesarFactura.php" method="POST">
    <input type="hidden" name="id_lote" value="<?php echo $lote['id_lote']; ?>">
    <input type="hidden" name="id_proveedor" value="<?php echo $lote['id_proveedor']; ?>">

    <label>Tipo de Factura:</label>
    <select name="tipo" required>
        <option value="Minorista">Minorista</option>
        <option value="Mayorista">Mayorista</option>
    </select><br><br>

    <label>Precio Unitario:</label>
    <input type="number" name="precio" step="0.01" required><br><br>

    <button type="submit">Generar Factura</button>
</form>
</body>
</html>
