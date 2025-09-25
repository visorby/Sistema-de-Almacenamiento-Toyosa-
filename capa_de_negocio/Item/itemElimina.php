<?php
	include("../../capa_de_datos/conexion.php");

	$id_item = $_GET['id_item'];

	$sql = "DELETE FROM items WHERE id_item='$id_item'";

	if (mysqli_query($link, $sql)) {
		header("Location: itemLista.php");
	} else {
		echo "Error al eliminar: " . mysqli_error($link);
	}
