<?php
include("../../capa_de_datos/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario de forma segura
    $id_lote = uniqid("LOT");
    $tipo = mysqli_real_escape_string($link, $_POST["tipo"]);
    $cantidad = intval($_POST["cantidad"]);
    $id_proveedor = mysqli_real_escape_string($link, $_POST["id_proveedor"]);

    // Insertar en la tabla lotes
    $sql = "INSERT INTO lotes (id_lote, tipo, cantidad, id_proveedor)
            VALUES ('$id_lote', '$tipo', '$cantidad', '$id_proveedor')";

    if (mysqli_query($link, $sql)) {
        // Redirigir al formulario de facturación con los parámetros correctos
        header("Location: ../facturas/facturaGenerar.php?id_lote=$id_lote&id_proveedor=$id_proveedor");
        exit;
    } else {
        echo "Error al guardar el lote: " . mysqli_error($link);
    }
}

// Cargar proveedores para el select
$sqlProveedores = "SELECT id_proveedor, razon_social FROM proveedores";
$proveedores = mysqli_query($link, $sqlProveedores);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registrar Lote</title>
    <link rel="stylesheet" href="../../capa_de_presentacion/css/estiloA.css">
</head>
<body>
<h1> Registrar Lote</h1>

<form method="post">
    <label>Proveedor:</label>
	<form method="GET" action="../lotesFactura/loteGuardar.php">
    <select name="id_proveedor" required>
        <option value="">Seleccione...</option>
        <?php while($p = mysqli_fetch_assoc($proveedores)) { ?>
            <option value="<?php echo $p['id_proveedor']; ?>"><?php echo $p['razon_social']; ?></option>
        <?php } ?>
    </select><br><br>

    <label>Tipo:</label>
    <select name="tipo" required>
        <option value="Minorista">Minorista</option>
        <option value="Mayorista">Mayorista</option>
    </select><br><br>

    <label>Cantidad:</label>
    <input type="number" name="cantidad" min="1" required><br><br>

    <button type="submit">Guardar Lote</button>
    <a href="../xframe/frameLotes.php" class="btn btn-danger">Cancelar</a>
</form>
</body>
</html>
