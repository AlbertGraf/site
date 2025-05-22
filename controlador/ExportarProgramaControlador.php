<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ProgramaModelo.php';

// Verificar si el usuario tiene sesión activa y es administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ../vista/inicio.html');
    exit();
}

$programaModelo = new ProgramaModelo($conn);
$id_programa = $_GET['id_programa'] ?? null;

if ($id_programa) {
    $programa = $programaModelo->obtenerProgramaPorId($id_programa);

    if ($programa) {
        // Crear carpeta "cuarentena" si no existe
        $carpeta = __DIR__ . '/../cuarentena';
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // Nombres de los archivos
        $archivo_xls = $carpeta . "/programa_" . $id_programa . ".xls";
        $archivo_csv = $carpeta . "/programa_" . $id_programa . ".csv";

        // **1. Crear archivo CSV**
        $csv_file = fopen($archivo_csv, 'w');
        fputcsv($csv_file, array_keys($programa)); // Agregar encabezados
        fputcsv($csv_file, array_values($programa)); // Agregar datos
        fclose($csv_file);

        // **2. Crear archivo XLS (Formato XML para Excel)**
        $contenido_xls = '<?xml version="1.0" encoding="UTF-8"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
                  xmlns:o="urn:schemas-microsoft-com:office:office"
                  xmlns:x="urn:schemas-microsoft-com:office:excel"
                  xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
                  xmlns:html="http://www.w3.org/TR/REC-html40">
        <Worksheet ss:Name="Programa">
        <Table>';

        // Agregar encabezados
        $contenido_xls .= '<Row>';
        foreach (array_keys($programa) as $campo) {
            $contenido_xls .= '<Cell><Data ss:Type="String">' . htmlspecialchars($campo) . '</Data></Cell>';
        }
        $contenido_xls .= '</Row>';

        // Agregar datos
        $contenido_xls .= '<Row>';
        foreach ($programa as $dato) {
            $contenido_xls .= '<Cell><Data ss:Type="String">' . htmlspecialchars($dato) . '</Data></Cell>';
        }
        $contenido_xls .= '</Row>';

        $contenido_xls .= '</Table></Worksheet></Workbook>';

        // Guardar el archivo XLS
        file_put_contents($archivo_xls, $contenido_xls);

        // Eliminar el programa de la base de datos
        if ($programaModelo->eliminarPrograma($id_programa)) {
            $_SESSION['mensaje_exito'] = "✅ El programa fue enviado a cuarentena. Se guardaron los archivos XLS y CSV.";
        } else {
            $_SESSION['mensaje_error'] = "❌ Error al eliminar el programa de la base de datos.";
        }
    } else {
        $_SESSION['mensaje_error'] = "❌ Error: Programa no encontrado.";
    }
} else {
    $_SESSION['mensaje_error'] = "❌ Error: ID de programa no proporcionado.";
}

// Redirigir de vuelta a gestionar_programas.php
header("Location: ../controlador/GestionarProgramasControlador.php");
exit();
?>
