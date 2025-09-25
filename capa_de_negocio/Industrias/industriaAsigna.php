<?php
include("../../logicaDatos/conexion.php");

	// Asignación
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id_proveedor = $_POST["id_proveedor"];
		$id_industria = $_POST["id_industria"];

		$sql = "INSERT INTO proveedor_industria (id_proveedor, id_industria)
				VALUES ('$id_proveedor', '$id_industria')";

		if (mysqli_query($link, $sql)) {
			echo "<script>alert('Proveedor asignado correctamente'); window.location='industrias.php';</script>";
		} else {
			echo "Error: " . mysqli_error($link);
		}
	}

	// Cargar listas
	$proveedores = mysqli_query($link, "SELECT id_proveedor, razon_social FROM proveedores ORDER BY razon_social");
	$industrias = mysqli_query($link, "SELECT id_industria, nombre_industria FROM industrias ORDER BY nombre_industria");
	?>
	<html>
	<head><title>Asignar Proveedor a Industria</title></head>
	<body>
	<h1>🏭 Asignar Proveedor a Industria</h1>
	<form method="post">
		<label>Proveedor:</label>
		<select name="id_proveedor" required>
			<option value="">Seleccione...</option>
			<?php while($p = mysqli_fetch_assoc($proveedores)) { ?>
				<option value="<?php echo $p['id_proveedor']; ?>"><?php echo $p['razon_social']; ?></option>
			<?php } ?>
		</select><br><br>

		<label>Industria:</label>
		<select name="id_industria" required>
			<option value="">Seleccione...</option>
			<?php while($i = mysqli_fetch_assoc($industrias)) { ?>
				<option value="<?php echo $i['id_industria']; ?>"><?php echo $i['nombre_industria']; ?></option>
			<?php } ?>
		</select><br><br>

		<button type="submit">Asignar</button>
	</form>
	</body>
</html>
