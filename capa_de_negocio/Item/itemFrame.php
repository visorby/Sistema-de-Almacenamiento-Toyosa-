<?php
include("../../capa_de_datos/conexion.php");

// Consulta de items con industria y proveedor
$sql = "SELECT i.*, p.razon_social, ind.industria AS industria
        FROM items i
        JOIN proveedores p ON i.id_proveedor = p.id_proveedor
        JOIN industrias ind ON i.id_industria = ind.id_industria
        ORDER BY ind.industria, p.razon_social";

$resultado = mysqli_query($link, $sql);
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Ítems</title>
</head>
<body>
    <h1>Lista de Ítems</h1>
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Industria</th>
                <th>Stock Actual</th>
                <th>Stock Mínimo</th>
				<th>Estado</th>
                <th>Proveedor</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $industriaActual = "";
        $proveedorActual = "";

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $estado = ($fila["stock_Actual"] < $fila["stock_Minimo"]) 
                          ? "Requiere reposición" 
                          : "Stock suficiente";

                // Separador por industria
                if ($fila["industria"] != $industriaActual) {
                    $industriaActual = $fila["industria"];
                    echo "<tr style='background:#ddd; font-weight:bold;'>
                            <td colspan='9'>Industria: {$industriaActual}</td>
                          </tr>";
                    $proveedorActual = ""; 
                }

                // Separador por proveedor
                if ($fila["razon_social"] != $proveedorActual) {
                    $proveedorActual = $fila["razon_social"];
                    echo "<tr style='background:#f0f0f0; font-style:italic;'>
                            <td colspan='9'>Proveedor: {$proveedorActual}</td>
                          </tr>";
                }
        ?>
            <tr>
                <td><?php echo $fila["id_item"]; ?></td>
                <td><?php echo $fila["nombre"]; ?></td>
                <td><?php echo $fila["categoria"]; ?></td>
                <td><?php echo $fila["industria"]; ?></td>
                <td><?php echo $fila["stock_Actual"]; ?></td>
                <td><?php echo $fila["stock_Minimo"]; ?></td>
                <td><?php echo $estado; ?></td>
                <td><?php echo $fila["razon_social"]; ?></td>
                <td>
                    <a href="../Item/itemModifica.php?modifica=1&id_item=<?php echo $fila['id_item']; ?>">Modificar</a> | 
                    <a href="../Item/itemElimina.php?id_item=<?php echo $fila['id_item']; ?>" onclick="return confirm('¿Eliminar este ítem?');">Eliminar</a>
                </td>
            </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='9'>No hay ítems registrados</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <div style="margin-top:15px;">
        <a href="../Item/itemModifica.php?modifica=0">Registrar Ítem</a>
    </div>
</body>
</html>
