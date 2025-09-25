<?php
include("../../capa_de_datos/conexion.php");

// Traer lotes con datos de proveedores
$sql = "SELECT l.id_lote, l.id_factura, l.tipo, l.cantidad, p.razon_social
        FROM lotes l
        JOIN proveedores p ON l.id_proveedor = p.id_proveedor";
$resultado = mysqli_query($link, $sql);
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lotes</title>
</head>
<body>
<div class="container">
    <h1>Lotes</h1>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <td>ID Lote</td>
                <td>ID Factura</td>
                <td>Tipo</td>
                <td>Cantidad</td>
                <td>Proveedor</td>
                <td>Operaciones</td>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {  
        ?>
            <tr>
                <td><?php echo $fila["id_lote"]; ?></td>
                <td><?php echo $fila["id_factura"] ?? "-"; ?></td>
                <td><?php echo $fila["tipo"]; ?></td>
                <td><?php echo $fila["cantidad"]; ?></td>
                <td><?php echo $fila["razon_social"]; ?></td>
                <td>
                    <a href="../lotesFactura/loteModifica.php?id_lote=<?php echo $fila['id_lote']; ?>&modifica=1" class="btn btn-secondary btn-sm">Modificar</a>
					<?php if (!empty($fila['id_factura'])): ?>
					  <a href="../lotesFactura/detalleFactura.php?id_factura=<?php echo urlencode($fila['id_factura']); ?>">Ver Factura</a>
					<?php else: ?>
					  <a href="../lotesFactura/generarFactura.php?id_lote=<?php echo urlencode($fila['id_lote']); ?>">Generar Factura</a>
					<?php endif; ?>


                    <!--<a href="../lotesFactura/loteEliminar.php?id_lote=<?php echo $fila['id_lote']; ?>" class="btn btn-danger btn-sm">Eliminar</a>-->
                </td>
            </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='6'>No hay registros</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <div class="text-center">
        <a href="../lotesFactura/loteModifica.php?modifica=0" class="btn-primary">Registrar Lote</a>
    </div>
	
</div>
</body>
</html>
