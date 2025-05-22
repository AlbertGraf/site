<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';
require_once __DIR__ . '/../libs/fpdf/fpdf.php';

session_start();

// Verificar autenticación
if (!isset($_SESSION['id_usuario'])) {
    die("Acceso denegado.");
}

// Obtener el género desde GET
$genero = $_GET['genero'] ?? null;
if (!$genero) {
    die("Error: Género no especificado.");
}

// Instanciar el modelo y obtener datos
$reportesModelo = new ReportesModelo($conn);
$beneficiarios = $reportesModelo->obtenerBeneficiariosPorGenero($genero);

if (!$beneficiarios) {
    die("No hay beneficiarios registrados con el género seleccionado.");
}

$totalBeneficiarios = count($beneficiarios);

// Clase personalizada para el PDF
class PDF extends FPDF {
    function Header() {
        global $genero;
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, utf8_decode('Alcaldía Tláhuac'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Reporte de Beneficiarios por Género: ' . ucfirst($genero)), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear y configurar el PDF
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

// Definir encabezados
$headers = ['Nombre Completo', 'Domicilio', 'Colonia', 'Edad', 'Género', 'Programa'];
$widths = [50, 50, 40, 25, 25, 60];

// Imprimir encabezados
foreach ($headers as $i => $col) {
    $pdf->Cell($widths[$i], 10, utf8_decode($col), 1, 0, 'C');
}
$pdf->Ln();

// Imprimir datos
$pdf->SetFont('Arial', '', 10);
foreach ($beneficiarios as $beneficiario) {
    $nombre_completo = $beneficiario['nombre'] . ' ' . $beneficiario['apellido_paterno'] . ' ' . $beneficiario['apellido_materno'];
    $pdf->Cell($widths[0], 10, utf8_decode($nombre_completo), 1);
    $pdf->Cell($widths[1], 10, utf8_decode($beneficiario['direccion']), 1);
    $pdf->Cell($widths[2], 10, utf8_decode($beneficiario['colonia']), 1);
    $pdf->Cell($widths[3], 10, $beneficiario['edad'], 1, 0, 'C');
    $pdf->Cell($widths[4], 10, ucfirst($beneficiario['sexo']), 1, 0, 'C');
    $pdf->Cell($widths[5], 10, utf8_decode($beneficiario['nombre_programa']), 1);
    $pdf->Ln();
}

// Agregar total de beneficiarios
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Total de registros: ' . $totalBeneficiarios, 0, 1, 'C');

// Generar PDF
$pdf->Output('D', 'Reporte_Beneficiarios_Genero.pdf'); 
exit;
?>
