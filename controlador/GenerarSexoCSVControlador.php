<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';

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

// Nombre del archivo CSV
$filename = "Reporte_Beneficiarios_Genero_" . ucfirst($genero) . ".csv";

// Encabezados para la descarga del archivo
header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=$filename");

// Abrir flujo de salida
$output = fopen("php://output", "w");

// Escribir encabezados
$headers = ['Nombre Completo', 'Domicilio', 'Colonia', 'Edad', 'Género', 'Programa'];
fputcsv($output, $headers, ',');

// Escribir datos
foreach ($beneficiarios as $beneficiario) {
    $nombre_completo = $beneficiario['nombre'] . ' ' . $beneficiario['apellido_paterno'] . ' ' . $beneficiario['apellido_materno'];
    $row = [
        $nombre_completo,
        $beneficiario['direccion'],
        $beneficiario['colonia'],
        $beneficiario['edad'],
        ucfirst($beneficiario['sexo']), // Se mantiene "sexo" porque proviene de la BD
        $beneficiario['nombre_programa']
    ];
    fputcsv($output, $row, ',');
}

// Cerrar flujo
fclose($output);
exit;
?>
