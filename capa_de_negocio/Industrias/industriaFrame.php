<?php
include("../../capa_de_datos/conexion.php");

// Consultar todas las industrias
$sql = "SELECT * FROM industrias";
$resultado = mysqli_query($link, $sql);
?>
<html>
<head>
    <title>Industrias</title>
</head>
<body>
<div class="container">
    <h1> Industrias</h1>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td>ID Industria</td>
                <td>Nombre Industria</td>
                <td>Descripción</td>
                <td>Operaciones</td>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr>
                <td><?php echo $fila["id_industria"]; ?></td>
                <td><?php echo $fila["industria"]; ?></td>
                <td><?php echo $fila["descripcion"]; ?></td>
                <!--<td><?php echo $fila["fecha_registro"]; ?></td>-->
                <td>
                    
                    <a href="../Industrias/industriaModifica.php?modifica=1&id=<?php echo $fila['id_industria']; ?>">Modificar</a> 
                </td>
            </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>No hay industrias registradas</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <div class="text-center" style="margin-top:15px;">
        <a href="../Industrias/industriaModifica.php?modifica=0" class="btn-primary"> Registrar Industria</a>
    </div>
</div>
</body>
</html>
