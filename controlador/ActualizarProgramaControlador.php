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
$id_programa = $_GET['id_programa'] ?? $_POST['id_programa'] ?? null;
$programa = null;
$error = null;

// Obtener datos del programa
if ($id_programa) {
    $programa = $programaModelo->obtenerProgramaPorId($id_programa);
    if (!$programa) {
        $error = "No se encontró el programa con ID $id_programa.";
    }
} else {
    $error = "No se proporcionó un ID de programa.";
}

// Procesar actualización del programa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_programa = $_POST['id_programa'];
    $nombre = $_POST['nombre_programa'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    if ($programaModelo->actualizarPrograma($id_programa, $nombre, $descripcion, $fecha_inicio, $fecha_fin)) {
        echo "<script>
                alert('Actualización exitosa');
                window.location.href = '../controlador/GestionarProgramasControlador.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Error al actualizar el programa');</script>";
    }
}

// Incluir la vista
include __DIR__ . '/../vista/admin/actualizar_programa.php';
?>
