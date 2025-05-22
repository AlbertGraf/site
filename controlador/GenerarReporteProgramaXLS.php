<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;

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

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer título
$sheet->setCellValue('A1', 'Alcaldía Tláhuac');
$sheet->setCellValue('A2', 'Reporte de Programa Social: ' . $nombre_programa);

// Unir celdas para los títulos
$sheet->mergeCells('A1:E1');
$sheet->mergeCells('A2:E2');

// Aplicar estilos al título
$styleArray = [
    'font' => [
        'bold' => true,
        'size' => 14,
        'color' => ['rgb' => '000000'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
];

$sheet->getStyle('A1:A2')->applyFromArray($styleArray);

// Encabezados de la tabla
$headers = ['Nombre', 'Domicilio', 'Colonia', 'Edad', 'Programa'];
$sheet->fromArray($headers, null, 'A4');

// Aplicar estilos a los encabezados
$sheet->getStyle('A4:E4')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4F81BD']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

// Insertar datos de los beneficiarios
$row = 5;
foreach ($beneficiarios as $beneficiario) {
    $nombre_completo = $beneficiario['nombre'] . ' ' . $beneficiario['apellido_paterno'] . ' ' . $beneficiario['apellido_materno'];
    $sheet->setCellValue("A{$row}", $nombre_completo);
    $sheet->setCellValue("B{$row}", $beneficiario['direccion']);
    $sheet->setCellValue("C{$row}", $beneficiario['colonia']);
    $sheet->setCellValue("D{$row}", $beneficiario['edad']);
    $sheet->setCellValue("E{$row}", $beneficiario['nombre_programa']);
    $row++;
}

// Ajustar el tamaño de las columnas automáticamente
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Aplicar bordes a la tabla
$sheet->getStyle("A4:E" . ($row - 1))->applyFromArray([
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
]);

// Generar el archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = 'Reporte_Programa_Social.xlsx';

// Enviar el archivo al navegador
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
