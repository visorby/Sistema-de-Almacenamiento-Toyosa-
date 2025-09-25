<?php
	include("../../capa_de_datos/conexion.php"); 
	$modifica = isset($_GET["modifica"]) ? $_GET["modifica"] : 0;
	$id_proveedor = "";

	if($modifica == 1 && isset($_GET["id_proveedor"])) {
		$id_proveedor = $_GET["id_proveedor"];
}


	$sql ="SELECT * FROM proveedores WHERE id_proveedor='".$id_proveedor."'";
	$resultado=mysqli_query($link,$sql);
	$razon_social="";
	$nombre_empresa="";
	$representante_legal="";
	$telefono="";
	$correo="";
	$tipo="";
	if($fila=mysqli_fetch_array($resultado)) {
		$razon_social=$fila["razon_social"];
		$nombre_empresa=$fila["nombre_empresa"];
		$representante_legal=$fila["representante_legal"];
		$telefono=$fila["telefono"];
		$correo=$fila["correo"];	
		$tipo=$fila["tipo"];
	}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Proveedores</title>
    <link rel="stylesheet" href="../../capa_de_presentacion/css/estiloA.css">
</head>
<body>
    <h1>Proveedores</h1>  
    <div class="container">
        <form method="GET" action="../proveedores/proveedorGuardar.php">
            <input type="hidden" name="modifica" value="<?php echo $modifica;?>">
            
            <label>Id</label>
            <input type="text" name="id" value="<?php echo $id_proveedor;?>" <?php if ($modifica==1) echo "readonly"; ?>>
            
            <label>Razon Social</label>
            <input type="text" name="razon" value="<?php echo $razon_social;?>">
            
            <label>Nombre Empresa</label>
            <input type="text" name="nombre" value="<?php echo $nombre_empresa;?>">
            
            <label>Representante legal</label>
            <input type="text" name="representante" value="<?php echo $representante_legal;?>">
			
			<label>Telefono</label>
            <input type="text" name="telefono" value="<?php echo $telefono;?>">
			
			<label>Correo Electronico</label>
            <input type="text" name="correo" value="<?php echo $correo;?>">
			
			 <label>Tipo:</label>
				<select name="tipo" required>
					<option value="Minorista">Minorista</option>
					<option value="Mayorista">Mayorista</option>
				</select><br><br>
            
            <div class="btn-group">
                <input type="submit" class="btn btn-primary" name="Guardar" value="Guardar">
                <a href="../xframe/frameProveedores.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
