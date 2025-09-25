<?php
	include("../../capa_de_datos/conexion.php");

	$modifica     = $_POST['modifica'];
	$id_item      = $_POST['id_item'];
	$nombre       = $_POST['nombre'];
	$categoria    = $_POST['categoria'];
	$id_industria = $_POST['id_industria'];
	$id_proveedor = $_POST['id_proveedor'];
	$stock_Actual = $_POST['stock_Actual'];
	$stock_Minimo = $_POST['stock_Minimo'];

	if ($modifica == 1) {
		$sql = "UPDATE items SET 
				nombre='$nombre',
				categoria='$categoria',
				id_industria='$id_industria',
				id_proveedor='$id_proveedor',
				stock_Actual='$stock_Actual',
				stock_Minimo='$stock_Minimo'
				WHERE id_item='$id_item'";
	} else {
		$sql = "INSERT INTO items (nombre, categoria, id_industria, id_proveedor, stock_Actual, stock_Minimo)
				VALUES ('$nombre','$categoria','$id_industria','$id_proveedor','$stock_Actual','$stock_Minimo')";
	}

	if (mysqli_query($link, $sql)) {
		header("Location: itemLista.php");
	} else {
		echo "Error: " . mysqli_error($link);
}
