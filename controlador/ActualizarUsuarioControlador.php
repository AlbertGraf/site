<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

// Verificar sesión y permisos
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ../vista/inicio.html');
    exit();
}

$usuarioModelo = new UsuarioModelo($conn);
$id_usuario = $_GET['id_usuario'] ?? $_POST['id_usuario'] ?? null;
$usuario = null;
$error = null;

// Obtener datos del usuario para mostrar en el formulario
if ($id_usuario) {
    $usuario = $usuarioModelo->obtenerUsuarioPorId($id_usuario);
    if (!$usuario) {
        $error = "No se encontró el usuario con ID $id_usuario.";
    }
} else {
    $error = "No se proporcionó un ID de usuario.";
}

// Procesar actualización del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $id_usuario = $_POST['id_usuario'] ?? null;
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $clave = trim($_POST['clave']);
    $rol = trim($_POST['rol']);

    if ($id_usuario && $usuarioModelo->actualizarUsuario($id_usuario, $nombre, $correo, $clave, $rol)) {
        echo "<script>
                alert('Actualización exitosa');
                window.location.href = '../controlador/GestionarUsuariosControlador.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Error al actualizar el usuario');</script>";
    }
}

// Incluir la vista con los datos
include __DIR__ . '/../vista/admin/actualizar_usuario.php';
?>
