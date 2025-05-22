<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';

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

// Nombre del programa social
$nombre_programa = $beneficiarios[0]['nombre_programa'] ?? 'Desconocido';

// Definir el nombre del archivo CSV
$filename = "Reporte_Programa_Social.csv";

// Configurar las cabeceras para descargar el archivo CSV
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Crear el archivo CSV
$output = fopen('php://output', 'w');

// Escribir la cabecera del archivo
fputcsv($output, ["Reporte de Programa Social: $nombre_programa"], ';');
fputcsv($output, ["Alcaldía Tláhuac"], ';');
fputcsv($output, []); // Línea vacía

// Escribir los encabezados de la tabla
$headers = ['Nombre', 'Domicilio', 'Colonia', 'Edad', 'Programa'];
fputcsv($output, $headers, ';');

// Escribir los datos de los beneficiarios en el CSV
foreach ($beneficiarios as $beneficiario) {
    $nombre_completo = $beneficiario['nombre'] . ' ' . $beneficiario['apellido_paterno'] . ' ' . $beneficiario['apellido_materno'];
    $fila = [
        $nombre_completo,
        $beneficiario['direccion'],
        $beneficiario['colonia'],
        $beneficiario['edad'],
        $beneficiario['nombre_programa']
    ];
    fputcsv($output, $fila, ';');
}

// Cerrar el archivo CSV
fclose($output);
exit;
?>
