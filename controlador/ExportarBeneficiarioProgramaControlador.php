<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/BeneficiarioProgramaModelo.php';

if (!isset($_GET['formato']) || !in_array($_GET['formato'], ['xls', 'csv'])) {
    die("Formato no válido.");
}

$formato = $_GET['formato'];
$beneficiarioProgramaModelo = new BeneficiarioProgramaModelo($conn);
$registros = $beneficiarioProgramaModelo->obtenerBeneficiariosProgramasParaExportar();

if (!$registros) {
    die("No hay datos para exportar.");
}

// Definir el nombre del archivo
$nombre_archivo = "beneficiario_programa_" . date("Ymd_His") . "." . $formato;

if ($formato === 'csv') {
    // Configurar encabezados para descarga CSV
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$nombre_archivo");

    // Abrir la salida estándar para escribir el CSV
    $salida = fopen("php://output", "w");

    // Escribir encabezados
    fputcsv($salida, ['ID Beneficiario', 'Nombre Beneficiario', 'Apellido Paterno', 'Apellido Materno', 'ID Programa', 'Nombre Programa', 'Fecha Asignación', 'Estado de Entrega']);

    // Escribir filas
    foreach ($registros as $registro) {
        fputcsv($salida, $registro);
    }

    fclose($salida);
    exit;
} elseif ($formato === 'xls') {
    // Configurar encabezados para descarga XLS
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$nombre_archivo");

    // Escribir encabezados de columnas
    echo "ID Beneficiario\tNombre Beneficiario\tApellido Paterno\tApellido Materno\tID Programa\tNombre Programa\tFecha Asignación\tEstado de Entrega\n";

    // Escribir datos de cada registro
    foreach ($registros as $registro) {
        echo implode("\t", $registro) . "\n";
    }

    exit;
}
?>
