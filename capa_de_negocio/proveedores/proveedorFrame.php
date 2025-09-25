<?php
include("../../capa_de_datos/conexion.php");

$sql = "SELECT * FROM proveedores";
$resultado = mysqli_query($link, $sql);
?>
<html>
<head>
    <title>Proveedores</title>
</head>
<body>
<div class="container">
    <h1>Proveedores</h1>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <td>ID</td>
                <td>Razon Social</td>
                <td>Nombre Empresa</td>
                <td>Representante Legal</td>
                <td>Telefono</td>
                <td>Correo</td>
                <td>Operaciones</td>
            </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                ?>
                <tr>
                    <td><?php echo $fila["id_proveedor"]; ?></td>
                    <td><?php echo $fila["razon_social"]; ?></td>
                    <td><?php echo $fila["nombre_empresa"]; ?></td>
                    <td><?php echo $fila["representante_legal"]; ?></td>
                    <td><?php echo $fila["telefono"]; ?></td>
					<td><?php echo $fila["correo"]; ?></td>
					
                    <td>
                        <a href="../proveedores/proveedorModifica.php?id=<?php echo $fila['id_proveedor']; ?>&modifica=1" class="btn btn-secondary btn-sm">Modificar</a>
                        <a href="../proveedores/proveedorElimina.php?id=<?php echo $fila['id_proveedor']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>No hay registros</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <div class="text-center">
        <a href="../proveedores/proveedorModifica.php?modifica=0" class="btn-primary">Registrar Proveedor</a>
    </div>
</div>
</body>
</html>
