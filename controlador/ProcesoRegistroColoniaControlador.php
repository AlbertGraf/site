<?php 
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/ReportesModelo.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['id_usuario'])) {
        die("No estás autenticado.");
    }

    // Obtener los datos enviados
    $id_usuario = $_SESSION['id_usuario'];
    $colonia = $_POST['colonia'] ?? null;
    $formato = $_POST['formato'] ?? null;

    // Verificar si los datos son completos
    if (!$colonia || !$formato) {
        die("Datos incompletos.");
    }

    try {
        $reportesModelo = new ReportesModelo($conn);

        // Registrar el reporte en la base de datos
        $id_reporte = $reportesModelo->registrarReporte($id_usuario, 'Colonia', $formato);

        // Obtener beneficiarios de la colonia
        $beneficiarios = $reportesModelo->obtenerBeneficiariosPorColonia($colonia);

        // Guardar en sesión los beneficiarios y la colonia
        $_SESSION['beneficiarios'] = $beneficiarios;
        $_SESSION['colonia'] = $colonia;

        // Redirigir según el formato
        $rutas = [
            "PDF" => "/alcaldia/controlador/GenerarColoniaPDFControlador.php",
            "CSV" => "/alcaldia/controlador/GenerarColoniaCSVControlador.php",
            "XLS" => "/alcaldia/controlador/GenerarColoniaXLSControlador.php"
        ];

        if (isset($rutas[$formato])) {
            header("Location: " . $rutas[$formato] . "?id_colonia=$colonia");
            exit();
        } else {
            die("Formato no válido.");
        }

    } catch (PDOException $e) {
        die("Error al registrar el reporte: " . $e->getMessage());
    }
}
?>
