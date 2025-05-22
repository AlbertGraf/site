<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';
require_once __DIR__ . '/../libs/fpdf/fpdf.php';

session_start();

if (!isset($_GET['id_programa'])) {
    die("Programa social no especificado.");
}

$id_programa = $_GET['id_programa'];

$reportesModelo = new ReportesModelo($conn);
$beneficiarios = $reportesModelo->obtenerBeneficiariosPorPrograma($id_programa);

if (!$beneficiarios) {
    die("No hay beneficiarios inscritos en este programa.");
}

$nombre_programa = $beneficiarios[0]['nombre_programa'] ?? 'Desconocido';

class PDF extends FPDF
{
    function Header()
    {
        global $nombre_programa;
        
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Alcaldia Tlahuac', 0, 1, 'C');
        
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode("Reporte de Programa Social: $nombre_programa"), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear PDF en orientación horizontal
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

// Encabezados de la tabla
$pdf->Cell(70, 10, 'Nombre', 1);
$pdf->Cell(70, 10, 'Domicilio', 1);
$pdf->Cell(50, 10, 'Colonia', 1);
$pdf->Cell(25, 10, 'Edad', 1);
$pdf->Cell(65, 10, 'Programa', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($beneficiarios as $row) {
    $nombre_completo = $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'];
    $pdf->Cell(70, 10, utf8_decode($nombre_completo), 1);
    $pdf->Cell(70, 10, utf8_decode($row['direccion']), 1);
    $pdf->Cell(50, 10, utf8_decode($row['colonia']), 1);
    $pdf->Cell(25, 10, $row['edad'], 1);
    $pdf->Cell(65, 10, utf8_decode($row['nombre_programa']), 1);
    $pdf->Ln();
}

// Total de registros
$total_registros = count($beneficiarios);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Total de registros: $total_registros", 0, 1, 'R');

// Descargar el PDF automáticamente
$pdf->Output('D', "Reporte_Programa_Social.pdf");
?>
