<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/BeneficiarioModelo.php';

if (!isset($_GET['formato']) || !in_array($_GET['formato'], ['xls', 'csv'])) {
    die("Formato no válido.");
}

$formato = $_GET['formato'];
$beneficiarioModelo = new BeneficiarioModelo($conn);
$beneficiarios = $beneficiarioModelo->obtenerBeneficiariosParaExportar();

if (!$beneficiarios) {
    die("No hay datos para exportar.");
}

// Definir el nombre del archivo
$nombre_archivo = "beneficiarios_" . date("Ymd_His") . "." . $formato;

if ($formato === 'csv') {
    // Configurar encabezados para descarga CSV
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$nombre_archivo");

    // Abrir la salida estándar para escribir el CSV
    $salida = fopen("php://output", "w");

    // Escribir encabezados
    fputcsv($salida, ['ID', 'Nombre', 'Apellido Paterno', 'Apellido Materno', 'Edad', 'Sexo', 'Dirección', 'Colonia', 'Alcaldía', 'Teléfono', 'Correo', 'Fecha Registro', 'Código Postal']);

    // Escribir filas
    foreach ($beneficiarios as $beneficiario) {
        fputcsv($salida, $beneficiario);
    }

    fclose($salida);
    exit;
} elseif ($formato === 'xls') {
    // Configurar encabezados para descarga XLS
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$nombre_archivo");

    // Escribir encabezados de columnas
    echo "ID\tNombre\tApellido Paterno\tApellido Materno\tEdad\tSexo\tDirección\tColonia\tAlcaldía\tTeléfono\tCorreo\tFecha Registro\tCódigo Postal\n";

    // Escribir datos de cada beneficiario
    foreach ($beneficiarios as $beneficiario) {
        echo implode("\t", $beneficiario) . "\n";
    }

    exit;
}
?>
