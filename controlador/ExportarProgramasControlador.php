<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ProgramaModelo.php';

if (!isset($_GET['formato']) || !in_array($_GET['formato'], ['xls', 'csv'])) {
    die("Formato no válido.");
}

$formato = $_GET['formato'];
$programaModelo = new ProgramaModelo($conn);
$programas = $programaModelo->obtenerProgramasParaExportar();

if (!$programas) {
    die("No hay datos para exportar.");
}

// Definir el nombre del archivo
$nombre_archivo = "programas_sociales_" . date("Ymd_His") . "." . $formato;

if ($formato === 'csv') {
    // Configurar encabezados para descarga CSV
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$nombre_archivo");

    // Abrir la salida estándar para escribir el CSV
    $salida = fopen("php://output", "w");

    // Escribir encabezados
    fputcsv($salida, ['ID', 'Nombre del Programa', 'Descripción', 'Fecha Inicio', 'Fecha Fin', 'Estado']);

    // Escribir filas
    foreach ($programas as $programa) {
        fputcsv($salida, $programa);
    }

    fclose($salida);
    exit;
} elseif ($formato === 'xls') {
    // Configurar encabezados para descarga XLS
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$nombre_archivo");

    // Escribir encabezados de columnas
    echo "ID\tNombre del Programa\tDescripción\tFecha Inicio\tFecha Fin\tEstado\n";

    // Escribir datos de cada programa
    foreach ($programas as $programa) {
        echo implode("\t", $programa) . "\n";
    }

    exit;
}
?>
