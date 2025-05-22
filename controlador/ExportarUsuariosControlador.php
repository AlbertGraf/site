<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

// Verificar si se especificó el formato
if (!isset($_GET['formato'])) {
    die("Formato no especificado.");
}

$formato = $_GET['formato'];
$usuarioModelo = new UsuarioModelo($conn);
$usuarios = $usuarioModelo->exportarUsuarios();

// Verificar si hay usuarios para exportar
if (!$usuarios) {
    die("No hay usuarios para exportar.");
}

if ($formato === "csv") {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="usuarios.csv"');

    $output = fopen("php://output", "w");
    fputcsv($output, array_keys($usuarios[0])); // Encabezados

    foreach ($usuarios as $usuario) {
        fputcsv($output, $usuario);
    }
    fclose($output);
    exit();
} elseif ($formato === "xls") {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="usuarios.xls"');

    $output = fopen("php://output", "w");
    fputcsv($output, array_keys($usuarios[0]), "\t"); // Encabezados en formato XLS

    foreach ($usuarios as $usuario) {
        fputcsv($output, $usuario, "\t");
    }
    fclose($output);
    exit();
} else {
    die("Formato no válido.");
}
?>
