<?php
require('./fpdf.php'); // Clase FPDF
include("../../capa_de_datos/conexion.php");

// 1) Validar id_factura
if (!isset($_GET['id_factura'])) {
    die("Error: Factura no especificada.");
}
$id_factura = mysqli_real_escape_string($link, $_GET['id_factura']);

// 2) Traer datos de la factura y proveedor
$sqlFactura = "SELECT f.id_factura, f.Fecha, f.MontoTotal, f.Tipo, f.Estado,
                      p.razon_social, p.nombre_empresa, p.telefono, p.correo
               FROM factura_proveedor f
               JOIN proveedores p ON f.id_proveedor = p.id_proveedor
               WHERE f.id_factura = '$id_factura'";
$resFactura = mysqli_query($link, $sqlFactura);

if (!$resFactura || mysqli_num_rows($resFactura) == 0) {
    die("Error: No se encontró la factura con id $id_factura.");
}

$factura = mysqli_fetch_assoc($resFactura);

// 3) Traer detalle de la factura (lotes)
$sqlDetalle = "SELECT d.id_detalle, d.id_lote, d.cantidad, d.precio_unitario, d.subtotal,
                      l.tipo AS tipo_lote
               FROM detalle_factura d
               JOIN lotes l ON d.id_lote = l.id_lote
               WHERE d.id_factura = '$id_factura'";
$resDetalle = mysqli_query($link, $sqlDetalle);
if (!$resDetalle) {
    die("Error: No se pudo obtener el detalle de la factura.");
}

// 4) Generar PDF
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Factura Proveedor', 0, 1, 'C');
        $this->Ln(5);

        // Cabecera de tabla
        $this->SetFont('Arial','B',12);
        $this->SetFillColor(200,200,200);
        $this->Cell(30,10,'Lote',1,0,'C',true);
        $this->Cell(40,10,'Tipo',1,0,'C',true);
        $this->Cell(40,10,'Cantidad',1,0,'C',true);
        $this->Cell(40,10,'Precio Unitario',1,0,'C',true);
        $this->Cell(40,10,'Subtotal',1,1,'C',true);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Datos de la factura y proveedor
$pdf->Cell(0,8,"Factura Nro: ".$factura['id_factura'],0,1);
$pdf->Cell(0,8,"Fecha: ".$factura['Fecha'],0,1);
$pdf->Cell(0,8,"Proveedor: ".$factura['razon_social'],0,1);
$pdf->Cell(0,8,"Empresa: ".$factura['nombre_empresa'],0,1);
$pdf->Cell(0,8,"Teléfono: ".$factura['telefono'],0,1);
$pdf->Cell(0,8,"Correo: ".$factura['correo'],0,1);
$pdf->Ln(5);

// Detalle de lotes
$total = 0;
while ($row = mysqli_fetch_assoc($resDetalle)) {
    $pdf->Cell(30,10,$row['id_lote'],1);
    $pdf->Cell(40,10,$row['tipo_lote'],1);
    $pdf->Cell(40,10,$row['cantidad'],1);
    $pdf->Cell(40,10,number_format($row['precio_unitario'],2),1);
    $pdf->Cell(40,10,number_format($row['subtotal'],2),1);
    $pdf->Ln();
    $total += $row['subtotal'];
}

// Total final
$pdf->SetFont('Arial','B',12);
$pdf->Cell(150,10,'TOTAL',1);
$pdf->Cell(40,10,number_format($total,2),1);

// Descargar PDF
$pdf->Output('D', 'Factura_'.$id_factura.'.pdf'); // Descarga directa
?>
