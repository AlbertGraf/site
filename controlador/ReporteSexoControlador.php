<?php
session_start();

// Verificar si el usuario tiene sesión activa y tiene un rol definido
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    die("No estás autenticado.");
}

// Determinar qué vista cargar según el rol del usuario
if ($_SESSION['rol'] === 'administrador') {
    require_once __DIR__ . '/../vista/admin/reporte_sexo.php';
} elseif ($_SESSION['rol'] === 'usuario') {
    require_once __DIR__ . '/../vista/usuario/reporte_sexo.php';
} else {
    die("Acceso denegado.");
}
?>
