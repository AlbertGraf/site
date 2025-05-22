<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/EntregaApoyoModelo.php';

// Verificar si el usuario tiene sesión activa y tiene un rol definido
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    header('Location: ../vista/inicio.html');
    exit();
}

$entregaApoyoModelo = new EntregaApoyoModelo($conn);

// Obtener la lista de programas activos
$programas = $entregaApoyoModelo->obtenerProgramasActivos();

// Determinar qué vista cargar según el rol del usuario
if ($_SESSION['rol'] === 'administrador') {
    require_once __DIR__ . '/../vista/admin/entrega_apoyo.php';
} elseif ($_SESSION['rol'] === 'usuario') {
    require_once __DIR__ . '/../vista/usuario/entrega_apoyo.php';
} else {
    header('Location: ../vista/inicio.html');
    exit();
}
?>
