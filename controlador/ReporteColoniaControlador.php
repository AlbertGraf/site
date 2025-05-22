<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';

// Verificar si el usuario tiene sesión activa y tiene un rol definido
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    die("Acceso denegado");
}

// Crear una instancia del modelo
$reportesModelo = new ReportesModelo($conn);
$colonias = $reportesModelo->obtenerColoniasConBeneficiarios();

// Determinar qué vista cargar según el rol del usuario
if ($_SESSION['rol'] === 'administrador') {
    require_once __DIR__ . '/../vista/admin/reporte_colonia.php';
} elseif ($_SESSION['rol'] === 'usuario') {
    require_once __DIR__ . '/../vista/usuario/reporte_colonia.php';
} else {
    die("Acceso denegado");
}
?>
