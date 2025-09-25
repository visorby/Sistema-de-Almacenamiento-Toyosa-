<?php
include("../../capa_de_datos/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id_industria = uniqid("IND");
		$nombre = $_POST["nombre_industria"];
		$descripcion = $_POST["descripcion"];

		$sql = "INSERT INTO industrias (id_industria, nombre_industria, descripcion)
				VALUES ('$id_industria', '$nombre', '$descripcion')";

		if (mysqli_query($link, $sql)) {
			echo "<script>alert('Industria registrada correctamente'); window.location='industrias.php';</script>";
		} else {
			echo "Error: " . mysqli_error($link);
		}
	}
	?>
	<html>
	<head><title>Nueva Industria</title></head>
	<body>
	<h1>➕ Registrar Industria</h1>
	<form method="post">
		<label>Nombre Industria:</label>
		<input type="text" name="nombre_industria" required><br><br>

		<label>Descripción:</label>
		<textarea name="descripcion"></textarea><br><br>

		<button type="submit">Guardar</button>
	</form>
	</body>
</html>
