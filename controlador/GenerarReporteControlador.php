<?php
session_start();

// Verificar si el usuario tiene sesión activa y tiene un rol definido
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    die("Acceso denegado");
}

// Determinar qué vista cargar según el rol del usuario
if ($_SESSION['rol'] === 'administrador') {
    require_once __DIR__ . '/../vista/admin/generar_reporte_form.php';
} elseif ($_SESSION['rol'] === 'usuario') {
    require_once __DIR__ . '/../vista/usuario/generar_reporte_form.php';
} else {
    die("Acceso denegado");
}
?>
