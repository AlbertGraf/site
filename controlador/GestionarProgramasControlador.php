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

// Actualizar el estado de los programas
$programaModelo->actualizarEstadosProgramas();

// Obtener la lista de programas
$programas = $programaModelo->obtenerProgramas();

// Incluir la vista con los datos
include __DIR__ . '/../vista/admin/gestionar_programas.php';
?>