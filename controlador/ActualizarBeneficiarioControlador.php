<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/BeneficiarioModelo.php';

// Verificar si el usuario tiene sesión activa y el rol está definido
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    header('Location: ../vista/inicio.html');
    exit();
}

$beneficiarioModelo = new BeneficiarioModelo($conn);
$id_beneficiario = $_GET['id_beneficiario'] ?? $_POST['id_beneficiario'] ?? null;
$beneficiario = null;

if ($id_beneficiario) {
    $beneficiario = $beneficiarioModelo->obtenerBeneficiarioPorId($id_beneficiario);
    if (!$beneficiario) {
        echo "<script>alert('Beneficiario no encontrado.'); window.location.href='../controlador/GestionarBeneficiariosListaControlador.php';</script>";
        exit();
    }
}

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($beneficiarioModelo->actualizarBeneficiario($_POST, $_FILES)) {
        echo "<script>
                alert('Datos actualizados correctamente.');
                window.location.href = '../controlador/GestionarBeneficiariosListaControlador.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Error al actualizar los datos.');</script>";
    }
}

// Definir las rutas de vistas según el rol del usuario
$rutas_vistas = [
    'administrador' => __DIR__ . '/../vista/admin/actualizar_beneficiario.php',
    'usuario' => __DIR__ . '/../vista/usuario/actualizar_beneficiario.php'
];

// Verificar si el rol tiene una vista asignada y cargarla
if (array_key_exists($_SESSION['rol'], $rutas_vistas)) {
    require_once $rutas_vistas[$_SESSION['rol']];
} else {
    die("Error: El rol '{$_SESSION['rol']}' no tiene acceso a esta página");
}
?>
