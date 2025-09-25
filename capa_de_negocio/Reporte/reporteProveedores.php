<?php
include("../../capa_de_datos/conexion.php");

// Consulta proveedores
$sql = "SELECT id_proveedor, razon_social, nombre_empresa, representante_legal, telefono, correo
        FROM proveedores";
$resultado = mysqli_query($link, $sql);
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Proveedores</title>
</head>
<body>
    <h1>Reporte de Proveedores</h1>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Razón Social</th>
                <th>Nombre Empresa</th>
                <th>Representante</th>
                <th>Teléfono</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_proveedor']}</td>
                            <td>{$fila['razon_social']}</td>
                            <td>{$fila['nombre_empresa']}</td>
                            <td>{$fila['representante_legal']}</td>
                            <td>{$fila['telefono']}</td>
                            <td>{$fila['correo']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay proveedores registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div style="margin-top:15px;">
        <a href="../fpdf/reportePDF.php" target="_blank"> Generar PDF</a> 
    </div>
</body>
</html>
