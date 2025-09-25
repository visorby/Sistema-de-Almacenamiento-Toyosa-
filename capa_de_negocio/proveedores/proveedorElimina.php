<?php
	include("../../capa_de_datos/conexion.php");
	$id_proveedor = $_GET["id_proveedor"];
	
	$sql ="delete from proveedores where id_proveedor='$id_proveedor'";
	mysqli_query($link,$sql);
	header ("Location: ../proveedor/proveedorFrame.php")
?>
	<script type="text/javascript">
		  document.location='../xframe/';
	</script>
