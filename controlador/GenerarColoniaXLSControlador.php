<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

session_start();

// Verificar si se pasó el parámetro de la colonia
if (!isset($_GET['id_colonia'])) {
    die("Colonia no especificada.");
}

$colonia = $_GET['id_colonia'];

// Consulta para obtener beneficiarios en la colonia seleccionada
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
    die("No hay beneficiarios en esta colonia.");
}

// Crear nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer título
$sheet->setCellValue('A1', 'Alcaldía Tláhuac');
$sheet->setCellValue('A2', 'Reporte de Beneficiarios - Colonia: ' . $colonia);
$sheet->mergeCells('A1:F1');
$sheet->mergeCells('A2:F2');

// Aplicar estilos al título
$sheet->getStyle('A1:A2')->applyFromArray([
    'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '000000']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

// Encabezados de la tabla
$headers = ['Nombre', 'Domicilio', 'Colonia', 'Edad', 'Sexo', 'Programa Social'];
$sheet->fromArray($headers, null, 'A4');

// Aplicar estilos a los encabezados
$sheet->getStyle('A4:F4')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4F81BD']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

// Insertar datos de los beneficiarios
$row = 5;
foreach ($beneficiarios as $beneficiario) {
    $nombre_completo = "{$beneficiario['nombre']} {$beneficiario['apellido_paterno']} {$beneficiario['apellido_materno']}";
    $programa_social = $beneficiario['nombre_programa'] ?? 'Sin programa';

    $data = [
        $nombre_completo,
        $beneficiario['direccion'],
        $beneficiario['colonia'],
        $beneficiario['edad'],
        $beneficiario['sexo'],
        $programa_social
    ];

    $sheet->fromArray($data, null, "A{$row}");
    $row++;
}

// Ajustar tamaño de columnas automáticamente
foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Aplicar bordes a la tabla
$sheet->getStyle("A4:F" . ($row - 1))->applyFromArray([
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
]);

// Generar archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = "Reporte_Beneficiarios_Colonia_" . str_replace(" ", "_", $colonia) . ".xlsx";

// Enviar archivo al navegador
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
