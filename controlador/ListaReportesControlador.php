<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';

// Verificar si el usuario tiene sesión activa
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../vista/inicio.html');
    exit();
}

$reportesModelo = new ReportesModelo($conn);
$reportes = $reportesModelo->obtenerReportes();

// Incluir la vista
require_once __DIR__ . '/../vista/admin/lista_reportes.php';
?>
