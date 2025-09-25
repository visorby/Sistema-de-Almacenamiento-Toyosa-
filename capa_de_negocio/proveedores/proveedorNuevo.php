<?php 

	if(isset($_GET["Cancelar"]))
		header("Location: ../proveedor/proveedorFrame.php");
		//exit();
		include("../../capa_de_datos/conexion.php");

		$modifica=$_GET["modifica"];
		$id_proveedor=$_GET["id_proveedor"];
		$razol_social=$_GET["razon_social"];
		$nombre_empresa=$_GET["nombre_empresa"];
		$representante_legal=$_GET["representante_lelgal"];
		$telefono=$_GET["telefono"];
		$correo=$_GET["correo"];
		$fecha_registro=$_GET["fecha_registro"];
		
		if($modifica==1)
			$sql="update proveedores set razon_social='$razon_social', nombre_empresa='$nombre_empresa', representante_legal='$representante_legal', telefono='$telefono', correo= '$correo', fecha_registro='$fecha_registro' where id_proveedor=$id_proveedor;";
		else
			$sql="INSERT INTO proveedores(id_proveedor,razon_social,nombre_empresa,representante_legal,telefono,correo, fecha_registro) VALUES ('$id_proveedor','$razon_social','$nombre_empresa','$representante_legal','$telefono','$correo','$fecha_registro')";
	mysqli_query($link,$sql);
	header("Location: ../proveedor/proveedorFrame.php");
?>