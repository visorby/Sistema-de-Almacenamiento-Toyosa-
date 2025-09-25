<?php
include("../../capa_de_datos/conexion.php");
require('./fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        /*$this->Image('logo.png', 185, 5, 20);*/
        $this->SetFont('Arial', 'B', 19);
        $this->Cell(45);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(110, 15, utf8_decode('SISTEMA DE ALMACEN TOYOSA'), 1, 1, 'C', 0);
        /*$this->Ln(3);
        $this->SetTextColor(103);
        $this->Cell(110);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(96, 10, utf8_decode("Ubicación : "), 0, 0, '', 0);
        $this->Ln(5);
        $this->Cell(110);
        $this->Cell(59, 10, utf8_decode("Teléfono : "), 0, 0, '', 0);
        $this->Ln(5);
        $this->Cell(110);
        $this->Cell(85, 10, utf8_decode("Correo : "), 0, 0, '', 0);
        $this->Ln(5);
        $this->Cell(110);
        $this->Cell(85, 10, utf8_decode("Sucursal : "), 0, 0, '', 0);
        $this->Ln(10);*/

        $this->SetTextColor(228, 100, 0);
        $this->Cell(50);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(100, 10, utf8_decode("REPORTE DE PROVEEDORES"), 0, 1, 'C', 0);
        $this->Ln(7);

        // Encabezados de la tabla
        $this->SetFillColor(228, 100, 0);
        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(163, 163, 163);
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(20, 10, utf8_decode('ID'), 1, 0, 'C', 1);
        $this->Cell(40, 10, utf8_decode('Razón Social'), 1, 0, 'C', 1);
        $this->Cell(40, 10, utf8_decode('Empresa'), 1, 0, 'C', 1);
        $this->Cell(40, 10, utf8_decode('Representante'), 1, 0, 'C', 1);
        $this->Cell(30, 10, utf8_decode('Teléfono'), 1, 0, 'C', 1);
        $this->Cell(30, 10, utf8_decode('Email'), 1, 1, 'C', 1);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->SetY(-15);
        $this->Cell(355, 10, utf8_decode(date('d/m/Y')), 0, 0, 'C');
    }
}

// Crear PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Consulta de proveedores
$sql = "SELECT id_proveedor, razon_social, nombre_empresa, representante_legal, telefono, correo FROM proveedores";
$result = mysqli_query($link, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($link));
}

// Rellenar tabla
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(20, 10, $row["id_proveedor"], 1, 0, 'C', 0);
    $pdf->Cell(40, 10, utf8_decode($row["razon_social"]), 1, 0, 'C', 0);
    $pdf->Cell(40, 10, utf8_decode($row["nombre_empresa"]), 1, 0, 'C', 0);
    $pdf->Cell(40, 10, utf8_decode($row["representante_legal"]), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode($row["telefono"]), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode($row["correo"]), 1, 1, 'C', 0);
}

// Mostrar PDF
$pdf->Output('I', 'ReporteProveedores.pdf');
