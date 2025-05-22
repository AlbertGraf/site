<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/RespaldoModelo.php';

if (!isset($_GET['formato']) || !in_array($_GET['formato'], ['xls', 'csv'])) {
    die("Formato no válido.");
}

$formato = $_GET['formato'];
$nombre_archivo = "respaldo_completo_" . date("Ymd_His") . "." . $formato;
$respaldoModelo = new RespaldoModelo($conn);
$tablas = $respaldoModelo->obtenerTablas();

if ($formato === 'csv') {
    // Configurar encabezados para descarga CSV
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$nombre_archivo");

    // Abrir la salida estándar para escribir el CSV
    $salida = fopen("php://output", "w");

    foreach ($tablas as $tabla) {
        $datos = $respaldoModelo->obtenerDatosTabla($tabla);
        if (!$datos) continue;

        // Escribir encabezado de la tabla
        fputcsv($salida, ["Tabla: $tabla"]);
        fputcsv($salida, array_keys($datos[0]));

        // Escribir filas
        foreach ($datos as $fila) {
            fputcsv($salida, $fila);
        }

        fputcsv($salida, [""]); // Espacio entre tablas
    }

    fclose($salida);
    exit;
} elseif ($formato === 'xls') {
    // Configurar encabezados para descarga XLS
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=$nombre_archivo");

    foreach ($tablas as $tabla) {
        $datos = $respaldoModelo->obtenerDatosTabla($tabla);
        if (!$datos) continue;

        echo "Tabla: $tabla\n";
        echo implode("\t", array_keys($datos[0])) . "\n";
        foreach ($datos as $fila) {
            echo implode("\t", $fila) . "\n";
        }
        echo "\n"; // Espacio entre tablas
    }

    exit;
}
?>
