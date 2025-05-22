<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/BeneficiarioModelo.php';

// Verificar si el usuario tiene sesión activa
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../vista/inicio.html');
    exit();
}

$beneficiarioModelo = new BeneficiarioModelo($conn);

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($beneficiarioModelo->registrarBeneficiario($_POST, $_FILES)) {
        echo "<script>
                alert('Registro exitoso');
                window.location.href = '../controlador/GestionarBeneficiariosControlador.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Error al registrar el beneficiario');</script>";
    }
}

// Determinar la vista a cargar según el rol
if ($_SESSION['rol'] === 'administrador') {
    include __DIR__ . '/../vista/admin/registrar_beneficiario.php';
} elseif ($_SESSION['rol'] === 'usuario') {
    include __DIR__ . '/../vista/usuario/registrar_beneficiario.php';
} else {
    header('Location: ../vista/inicio.html');
    exit();
}
?>
