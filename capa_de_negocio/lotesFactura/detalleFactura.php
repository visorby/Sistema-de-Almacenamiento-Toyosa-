<?php
// detalleFactura.php
include("../../capa_de_datos/conexion.php");

// 1) Validar que exista id_factura en la URL
$id_factura = '';
if (isset($_GET['id_factura'])) {
    // limpiar y escapar
    $id_factura = trim($_GET['id_factura']);
    $id_factura = mysqli_real_escape_string($link, $id_factura);
}

if ($id_factura === '') {
    echo "<p><strong>Error:</strong> No se recibió <em>id_factura</em>. Asegúrate de abrir esta página con <code>?id_factura=FAC###</code>.</p>";
    echo "<p><a href='../../tuRuta/lotes.php'>Volver a la lista de lotes</a></p>";
    exit;
}

// 2) Consultar la cabecera de la factura (verifica nombres de columnas según tu BD)
$sqlFactura = "SELECT f.id_factura, f.Fecha, f.Tipo, f.MontoTotal, f.Estado,
                      p.razon_social, p.nombre_empresa, p.telefono, p.correo
               FROM factura_proveedor f
               LEFT JOIN proveedores p ON f.id_proveedor = p.id_proveedor
               WHERE f.id_factura = '$id_factura'";

$resFactura = mysqli_query($link, $sqlFactura);
if ($resFactura === false) {
    die("Error en la consulta de cabecera: " . mysqli_error($link));
}

if (mysqli_num_rows($resFactura) === 0) {
    echo "<p>No existe la factura con id <strong>" . htmlspecialchars($id_factura) . "</strong>.</p>";
    echo "<p><a href='../../tuRuta/lotes.php'>Volver a lotes</a></p>";
    exit;
}

$factura = mysqli_fetch_assoc($resFactura);

// 3) Consultar el detalle (detalle_factura + info de lote si hace falta)
$sqlDetalle = "SELECT d.id_detalle, d.id_lote, d.cantidad, d.precio_unitario, d.subtotal,
                      l.tipo AS tipo_lote
               FROM detalle_factura d
               LEFT JOIN lotes l ON d.id_lote = l.id_lote
               WHERE d.id_factura = '$id_factura'";

$resDetalle = mysqli_query($link, $sqlDetalle);
if ($resDetalle === false) {
    die("Error en la consulta de detalle: " . mysqli_error($link));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Detalle Factura <?php echo htmlspecialchars($factura['id_factura']); ?></title>
	
</head>
<body>
    <h1>Factura: <?php echo htmlspecialchars($factura['id_factura']); ?></h1>
    <p><strong>Proveedor:</strong> <?php echo htmlspecialchars($factura['razon_social'] ?? 'N/D'); ?>
       (<?php echo htmlspecialchars($factura['nombre_empresa'] ?? ''); ?>)</p>
    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($factura['Fecha']); ?></p>
    <p><strong>Tipo:</strong> <?php echo htmlspecialchars($factura['Tipo']); ?></p>
    <p><strong>Estado:</strong> <?php echo htmlspecialchars($factura['Estado']); ?></p>
    <p><strong>Monto Total:</strong> <?php echo number_format((float)$factura['MontoTotal'],2); ?></p>

    <hr>
    <h2>Detalle</h2>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>ID Detalle</th>
                <th>ID Lote</th>
                <th>Tipo Lote</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($resDetalle) > 0) {
            while ($row = mysqli_fetch_assoc($resDetalle)) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['id_detalle'])."</td>";
                echo "<td>".htmlspecialchars($row['id_lote'])."</td>";
                echo "<td>".htmlspecialchars($row['tipo_lote'])."</td>";
                echo "<td>".(int)$row['cantidad']."</td>";
                echo "<td>".number_format((float)$row['precio_unitario'],2)."</td>";
                echo "<td>".number_format((float)$row['subtotal'],2)."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay detalles para esta factura.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <p><a href="../fpdf/factura.php?id_factura=<?php echo urlencode($factura['id_factura']); ?>"> Descargar/Ver PDF</a></p>
    <p><a href="../xframe/framelotes.php">Volver a lotes</a></p>
</body>
</html>
