<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';

// Verificar si el usuario tiene sesión activa
if (!isset($_SESSION['id_usuario'])) {
    die(json_encode(['success' => false, 'message' => 'Acceso denegado']));
}

// Comprobar si se reciben los parámetros necesarios
if (isset($_POST['id_programa']) && isset($_POST['formato'])) {
    $id_programa = $_POST['id_programa'];
    $formato = $_POST['formato'];
    $id_usuario = $_SESSION['id_usuario']; // Obtener el ID del usuario desde la sesión
    $nombre_reporte = 'Programa_Social'; // Nombre del reporte

    $reportesModelo = new ReportesModelo($conn);
    $resultado = $reportesModelo->registrarReporte($id_usuario, $nombre_reporte, $formato);

    if ($resultado) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar el reporte']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parámetros inválidos']);
}
?>
