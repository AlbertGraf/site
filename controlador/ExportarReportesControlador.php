<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';

if (!isset($_GET['formato']) || !in_array($_GET['formato'], ['xls', 'csv'])) {
    die("Formato no válido.");
}

$formato = $_GET['formato'];
$reportesModelo = new ReportesModelo($conn);
$reportes = $reportesModelo->obtenerReportesParaExportar();

if (!$reportes) {
    die("No hay datos para exportar.");
}

// Definir el nombre del archivo
$nombre_archivo = "reportes_" . date("Ymd_His") . "." . $formato;

if ($formato === 'csv') {
    // Configurar encabezados para descarga CSV
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$nombre_archivo");

    // Abrir la salida estándar para escribir el CSV
    $salida = fopen("php://output", "w");

    // Escribir encabezados
    fputcsv($salida, ['ID Reporte', 'Usuario', 'Nombre del Reporte', 'Fecha de Generación', 'Formato']);

    // Escribir filas
    foreach ($reportes as $reporte) {
        fputcsv($salida, $reporte);
    }

    fclose($salida);
    exit;
} elseif ($formato === 'xls') {
    // Configurar encabezados para descarga XLS
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$nombre_archivo");

    // Escribir encabezados de columnas
    echo "ID Reporte\tUsuario\tNombre del Reporte\tFecha de Generación\tFormato\n";

    // Escribir datos de cada reporte
    foreach ($reportes as $reporte) {
        echo implode("\t", $reporte) . "\n";
    }

    exit;
}
?>
