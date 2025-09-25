<?php 

	if(isset($_GET["Cancelar"]))
		header("Location: ../lotesFactura/loteFrame.php");
		//exit();
		include("../../capa_de_datos/conexion.php");

		$modifica=$_GET["modifica"];
		$id_lote=$_GET["id_lote"];
		$tipo=$_GET["tipo"];
		$cantidad=$_GET["cantidad"];
		
		if($modifica==1)
			$sql="update lotes set tipo='$tipo', cantidad='$cantidad' where id_lote=$id_lote;";
		else
			$sql="INSERT INTO lotes(id_lote,tipo,cantidad) VALUES ('$id_lote','$tipo','$cantidad')";
	mysqli_query($link,$sql);
	header("Location: ../lotesFactura/loteFrame.php");
?>