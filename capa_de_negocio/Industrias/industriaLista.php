<?php
	include("../../capa_de_datos/conexion.php");

	$sql = "SELECT i.id_industria, i.nombre_industria, i.descripcion, 
				   p.id_proveedor, p.razon_social
			FROM industrias i
			LEFT JOIN proveedor_industria pi ON i.id_industria = pi.id_industria
			LEFT JOIN proveedores p ON pi.id_proveedor = p.id_proveedor
			ORDER BY i.nombre_industria, p.razon_social";

	$resultado = mysqli_query($link, $sql);

	$datos = [];
	while ($fila = mysqli_fetch_assoc($resultado)) {
		$datos[$fila["id_industria"]]["nombre"] = $fila["nombre"];
		$datos[$fila["id_industria"]]["descripcion"] = $fila["descripcion"];
		$datos[$fila["id_industria"]]["proveedores"][] = $fila["razon_social"];
	}
	?>
<html>
	<head><title>Industrias</title></head>
	<body>
	<h1>🏭 Industrias y Proveedores</h1>
	<a href="industriaNueva.php">➕ Nueva Industria</a> | 
	<a href="asignarIndustria.php">📌 Asignar Proveedor</a>
	<hr>
	<?php foreach ($datos as $id => $info) { ?>
		<h3><?php echo $info["nombre"]; ?> (<?php echo $info["descripcion"]; ?>)</h3>
		<ul>
			<?php if (!empty($info["proveedores"][0])) {
				foreach ($info["proveedores"] as $prov) {
					echo "<li>$prov</li>";
				}
			} else {
				echo "<li><em>Sin proveedores asignados</em></li>";
			} ?>
		</ul>
	<?php } ?>
	</body>
</html>
