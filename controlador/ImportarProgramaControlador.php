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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo_csv'])) {
    $archivo_csv = $_FILES['archivo_csv']['tmp_name'];

    if ($programaModelo->importarProgramaDesdeCSV($archivo_csv)) {
        $_SESSION['mensaje_exito'] = "✅ Programa habilitado nuevamente.";
    } else {
        $_SESSION['mensaje_error'] = "❌ Error al importar el programa.";
    }
}

// Redirigir de nuevo a gestionar_programas.php
header("Location: ../controlador/GestionarProgramasControlador.php");
exit();
?>
