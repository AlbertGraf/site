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

// Manejar el registro de programa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_programa = $_POST['id_programa'];
    $nombre = $_POST['nombre_programa'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    if ($programaModelo->registrarPrograma($id_programa, $nombre, $descripcion, $fecha_inicio, $fecha_fin)) {
        echo "<script>
                alert('Registro exitoso');
                window.location.href = '../controlador/GestionarProgramasControlador.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Error al registrar el programa');</script>";
    }
}

// Incluir la vista
include __DIR__ . '/../vista/admin/registrar_programa.php';
?>
