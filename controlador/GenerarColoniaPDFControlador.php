<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../libs/fpdf/fpdf.php';
session_start();

// Verificar que se ha pasado el parámetro id_colonia
if (!isset($_GET['id_colonia'])) {
    die("Colonia no especificada.");
}

$colonia = $_GET['id_colonia']; // Obtener el valor de la colonia desde la URL

// Consulta para obtener los beneficiarios de la colonia
$query = "
    SELECT B.nombre, B.apellido_paterno, B.apellido_materno, B.direccion, B.colonia, B.edad, B.sexo, P.nombre_programa 
    FROM Beneficiarios B
    LEFT JOIN Registros_Beneficiarios R ON B.id_beneficiario = R.id_beneficiario
    LEFT JOIN Programas_Sociales P ON R.id_programa = P.id_programa
    WHERE B.colonia = ?
";

$stmt = $conn->prepare($query);
$stmt->execute([$colonia]);
$beneficiarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$beneficiarios) {
    die("No hay beneficiarios registrados en esta colonia.");
}

// Obtener el nombre de la colonia
$nombre_colonia = $beneficiarios[0]['colonia'] ?? 'Desconocida';

// Definir clase PDF
class PDF extends FPDF
{
    function Header()
    {
        global $nombre_colonia;
        
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, utf8_decode('Alcaldía Tláhuac'), 0, 1, 'C');
        
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode("Reporte de Beneficiarios - Colonia: $nombre_colonia"), 0, 1, 'C');
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
$pdf = new PDF('L', 'mm', 'A4'); // 'L' para Landscape
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

// Encabezados de la tabla
$headers = ['Nombre', 'Dirección', 'Edad', 'Sexo', 'Programa'];
$widths = [60, 70, 20, 20, 80];

foreach ($headers as $i => $header) {
    $pdf->Cell($widths[$i], 10, utf8_decode($header), 1, 0, 'C');
}
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($beneficiarios as $row) {
    $nombre_completo = "{$row['nombre']} {$row['apellido_paterno']} {$row['apellido_materno']}";
    
    $data = [
        $nombre_completo,
        $row['direccion'],
        $row['edad'],
        $row['sexo'],
        $row['nombre_programa'] ?? 'Sin programa'
    ];

    foreach ($data as $i => $value) {
        $pdf->Cell($widths[$i], 10, utf8_decode($value), 1);
    }
    $pdf->Ln();
}

// Total de registros
$total_registros = count($beneficiarios);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Total de registros: $total_registros", 0, 1, 'R');

// Descargar el PDF automáticamente
$pdf->Output('D', "Reporte_Colonia_" . str_replace(" ", "_", $nombre_colonia) . ".pdf");
?>
