<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

session_start();

// Verificar autenticación
if (!isset($_SESSION['id_usuario'])) {
    die("Acceso denegado.");
}

// Obtener género desde GET
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

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// **Título y Subtítulo**
$sheet->setCellValue('A1', 'Alcaldía Tláhuac');
$sheet->mergeCells('A1:F1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue('A2', 'Reporte de Programa por Género: ' . ucfirst($genero));
$sheet->mergeCells('A2:F2');
$sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// **Encabezados de la tabla**
$headers = ['Nombre Completo', 'Domicilio', 'Colonia', 'Edad', 'Género', 'Programa'];
$columnas = ['A', 'B', 'C', 'D', 'E', 'F'];

$sheet->fromArray($headers, null, 'A4');

// **Estilos para los encabezados**
$styleArray = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
];

$sheet->getStyle('A4:F4')->applyFromArray($styleArray);

// **Insertar datos en la tabla**
$rowNum = 5;
foreach ($beneficiarios as $beneficiario) {
    $nombre_completo = $beneficiario['nombre'] . ' ' . $beneficiario['apellido_paterno'] . ' ' . $beneficiario['apellido_materno'];
    $sheet->setCellValue("A$rowNum", $nombre_completo);
    $sheet->setCellValue("B$rowNum", $beneficiario['direccion']);
    $sheet->setCellValue("C$rowNum", $beneficiario['colonia']);
    $sheet->setCellValue("D$rowNum", $beneficiario['edad']);
    $sheet->setCellValue("E$rowNum", ucfirst($beneficiario['sexo']));
    $sheet->setCellValue("F$rowNum", $beneficiario['nombre_programa']);
    $rowNum++;
}

// **Ajustar ancho de columnas automáticamente**
foreach ($columnas as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// **Generar y descargar el archivo Excel**
$filename = "Reporte_Beneficiarios_Genero_" . ucfirst($genero) . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
