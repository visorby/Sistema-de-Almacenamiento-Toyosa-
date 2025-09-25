<?php
	include("../../capa_de_datos/conexion.php");

	if (isset($_POST["Cancelar"])) {
		header("Location: ../lotesFactura/loteFrame.php");
		exit();
	}

	$modifica = isset($_POST["modifica"]) ? intval($_POST["modifica"]) : 0;
	$id_lote = isset($_POST["id_lote"]) ? intval($_POST["id_lote"]) : 0;
	$tipo = isset($_POST["tipo"]) ? trim($_POST["tipo"]) : "";
	$cantidad = isset($_POST["cantidad"]) ? intval($_POST["cantidad"]) : 0;

	if ($tipo == "" || $cantidad <= 0 || $fecha_facturacion == "") {
		die("Error: faltan datos obligatorios.");
	}

	if ($modifica == 1 && $id_lote > 0) {
		// Actualiza
		$sql = "UPDATE lotes 
				SET tipo='$tipo', cantidad='$cantidad', WHERE id_lote=$id_lote";
		mysqli_query($link, $sql);
		header("Location: ../lotesFactura/loteFrame.php");
		exit();
	} else {
		// Insertar nuevo lote
		$sql = "INSERT INTO lotes (tipo, cantidad,  
				VALUES ('$tipo', '$cantidad')";
		mysqli_query($link, $sql);

		// Obtener id del lote recién creado
		$id_lote_nuevo = mysqli_insert_id($link);

		// Redirigir a formulario de facturación
		header("Location: ../lotesFactura/FacturaModifica.php?id_lote=" . $id_lote_nuevo);
		exit();
	}
?>
