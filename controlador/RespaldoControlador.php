<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ../vista/inicio.html');
    exit();
}

// Cargar la vista
require_once __DIR__ . '/../vista/admin/respaldo.php';
?>
