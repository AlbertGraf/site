<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/BeneficiarioModelo.php';

// Verificar si el usuario tiene sesión activa y tiene un rol definido
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    header('Location: ../vista/inicio.html');
    exit();
}

$beneficiarioModelo = new BeneficiarioModelo($conn);

if (isset($_GET['id_beneficiario'])) {
    $id_beneficiario = $_GET['id_beneficiario'];

    // Intentar eliminar el beneficiario usando el modelo
    if ($beneficiarioModelo->eliminarBeneficiario($id_beneficiario)) {
        echo "<script>
                alert('Beneficiario eliminado correctamente.');
                window.location.href = '../controlador/GestionarBeneficiariosListaControlador.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: Beneficiario no encontrado o no se pudo eliminar.');
                window.location.href = '../controlador/GestionarBeneficiariosListaControlador.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Solicitud inválida.');
            window.location.href = '../controlador/GestionarBeneficiariosListaControlador.php';
          </script>";
}
?>
