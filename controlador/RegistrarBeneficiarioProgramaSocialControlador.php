<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/BeneficiarioProgramaModelo.php';

// Verificar si el usuario tiene sesión activa y tiene un rol definido
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    header('Location: ../vista/inicio.html');
    exit();
}

$beneficiarioProgramaModelo = new BeneficiarioProgramaModelo($conn);

// Obtener lista de beneficiarios
$beneficiarios = $beneficiarioProgramaModelo->obtenerBeneficiarios();

// Determinar qué vista cargar según el rol del usuario
if ($_SESSION['rol'] === 'administrador') {
    require_once __DIR__ . '/../vista/admin/registrar_beneficiario_programa_social.php';
} elseif ($_SESSION['rol'] === 'usuario') {
    require_once __DIR__ . '/../vista/usuario/registrar_beneficiario_programa_social.php';
} else {
    header('Location: ../vista/inicio.html');
    exit();
}
?>
