<?php
include("../../capa_de_datos/conexion.php");

$modifica = isset($_GET['modifica']) ? $_GET['modifica'] : 0;
$id_item = isset($_GET['id_item']) ? $_GET['id_item'] : "";

$nombre = $categoria = $industria_selected = $stock_actual = $stock_minimo = $id_proveedor = "";
if ($modifica == 1 && $id_item != "") {
    $sql = "SELECT * FROM items WHERE id_item='" . mysqli_real_escape_string($link, $id_item) . "'";
    $res = mysqli_query($link, $sql);
    if ($res && $fila = mysqli_fetch_assoc($res)) {

        $nombre    = isset($fila['nombre']) ? $fila['nombre'] : "";
        $categoria = isset($fila['categoria']) ? $fila['categoria'] : "";

        // INDUSTRIA
        if (isset($fila['id_industria'])) {
            $industria_selected = $fila['id_industria'];
        } elseif (isset($fila['industria'])) {
            $industria_selected = $fila['industria'];
        }

        // STOCK
        if (isset($fila['stock_actual'])) {
            $stock_actual = $fila['stock_actual'];
        } elseif (isset($fila['stock_Actual'])) {
            $stock_actual = $fila['stock_Actual'];
        }

        if (isset($fila['stock_minimo'])) {
            $stock_minimo = $fila['stock_minimo'];
        } elseif (isset($fila['stock_Minimo'])) {
            $stock_minimo = $fila['stock_Minimo'];
        }

        $id_proveedor = isset($fila['id_proveedor']) ? $fila['id_proveedor'] : "";
    }
}

// Listar industrias y proveedores 
$industriaRes = mysqli_query($link, "SELECT * FROM industrias");
$proveedorRes = mysqli_query($link, "SELECT * FROM proveedores");
?>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($modifica==1) ? "Modificar Ítem" : "Registrar Ítem"; ?></title>
    <link rel="stylesheet" href="../../capa_de_presentacion/css/estiloA.css">
</head>
<body>
    <h1><?php echo ($modifica==1) ? "Modificar Ítem" : "Registrar Ítem"; ?></h1>

    <form method="POST" action="itemGuardar.php">
        <input type="hidden" name="id_item" value="<?php echo htmlspecialchars($id_item); ?>">
        <input type="hidden" name="modifica" value="<?php echo htmlspecialchars($modifica); ?>">

        Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required><br><br>
        Categoría: <input type="text" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>"><br><br>

        Industria:
        <select name="id_industria" required>
            <option value="">Seleccione</option>
            <?php
            // Recorremos industrias
            if ($industriaRes && mysqli_num_rows($industriaRes) > 0) {
                while ($ind = mysqli_fetch_assoc($industriaRes)) {

                    $valor = isset($ind['id_industria']) ? $ind['id_industria'] : $ind['industria'];
                    $label = isset($ind['industria']) ? $ind['industria'] : (isset($ind['nombre']) ? $ind['nombre'] : $valor);

                    // comparar 
                    $selected = ($industria_selected !== "" && (string)$industria_selected === (string)$valor) ? "selected" : "";
                    echo "<option value=\"" . htmlspecialchars($valor) . "\" $selected>" . htmlspecialchars($label) . "</option>";
                }
            }
            ?>
        </select><br><br>

        Proveedor:
        <select name="id_proveedor" required>
            <option value="">Seleccione</option>
            <?php
            if ($proveedorRes && mysqli_num_rows($proveedorRes) > 0) {
                while ($prov = mysqli_fetch_assoc($proveedorRes)) {
                    $provValue = isset($prov['id_proveedor']) ? $prov['id_proveedor'] : "";
                    $provLabel = isset($prov['razon_social']) ? $prov['razon_social'] : $provValue;
                    $selProv = ($id_proveedor !== "" && (string)$id_proveedor === (string)$provValue) ? "selected" : "";
                    echo "<option value=\"" . htmlspecialchars($provValue) . "\" $selProv>" . htmlspecialchars($provLabel) . "</option>";
                }
            }
            ?>
        </select><br><br>

        Stock Actual: <input type="number" name="stock_actual" value="<?php echo htmlspecialchars($stock_actual); ?>" required><br><br>
        Stock Mínimo: <input type="number" name="stock_minimo" value="<?php echo htmlspecialchars($stock_minimo); ?>" required><br><br>

        <input type="submit" value="Guardar">
        <a href="../xframe/frameItem.php" class="btn btn-danger">Cancelar</a>
    </form>
</body>
</html>
