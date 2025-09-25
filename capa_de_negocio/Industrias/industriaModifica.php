<?php
include("../../capa_de_datos/conexion.php");

$modifica = isset($_GET["modifica"]) ? $_GET["modifica"] : 0;
if ($modifica == 1) {
    $id_industria = $_GET["id"];
} else {
    $id_industria = "";
}

$sql = "SELECT * FROM industrias WHERE id_industria='$id_industria'";
$resultado = mysqli_query($link, $sql);

$industria = "";
$descripcion = "";

if ($fila = mysqli_fetch_assoc($resultado)) {
    $industria = $fila["industria"];
    $descripcion = $fila["descripcion"];
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro de Industria</title>
    <link rel="stylesheet" href="../../capa_de_presentacion/css/estiloA.css">
</head>
<body>
    <h1>🏭 Registro de Industria</h1>

    <form method="POST" action="../Industrias/industriaGuardar.php">
        <input type="hidden" name="modifica" value="<?php echo $modifica; ?>">

        <label>ID Industria</label>
        <input type="text" name="id_industria" 
               value="<?php echo $id_industria; ?>" 
               <?php if ($modifica==1) echo "readonly"; ?>>

        <label>Nombre de la Industria</label>
        <input type="text" name="industria" value="<?php echo $industria; ?>">

        <label>Descripción</label>
        <textarea name="descripcion"><?php echo $descripcion; ?></textarea>

        <div style="margin-top:10px;">
            <input type="submit" class="btn btn-primary" name="Guardar" value="Guardar">
            <a href="../xframe/frameIndustrias.php" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</body>
</html>
