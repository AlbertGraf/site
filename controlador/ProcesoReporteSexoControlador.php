<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['id_usuario'])) {
        die("No estás autenticado.");
    }

    $id_usuario = $_SESSION['id_usuario'];
    $genero = $_POST['genero'] ?? null;
    $formato = $_POST['formato'] ?? null;

    if (!$genero || !$formato) {
        die("Datos incompletos.");
    }

    try {
        // Registrar el reporte en la base de datos
        $reporteModelo = new ReportesModelo($conn);
        $reporteModelo->registrarReporte($id_usuario, 'Género', $formato);

        // Redirigir según el formato seleccionado
        if ($formato === "PDF") {
            header("Location: /alcaldia/controlador/GenerarSexoPDFControlador.php?genero=$genero");
        } elseif ($formato === "CSV") {
            header("Location: /alcaldia/controlador/GenerarSexoCSVControlador.php?genero=$genero");
        } elseif ($formato === "XLS") {
            header("Location: /alcaldia/controlador/GenerarSexoXLSControlador.php?genero=$genero");
        } else {
            die("Formato no válido.");
        }
        exit();

    } catch (PDOException $e) {
        die("Error al registrar el reporte: " . $e->getMessage());
    }
}
?>
