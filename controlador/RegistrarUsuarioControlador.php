<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

// Verificar que el usuario sea administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ../vista/inicio.html');
    exit();
}

// Instancia del modelo
$usuarioModelo = new UsuarioModelo($conn);

// Manejar el registro de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = trim($_POST['id_usuario']);
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $clave = trim($_POST['clave']);
    $rol = trim($_POST['rol']);

    if ($usuarioModelo->registrarUsuario($id_usuario, $nombre, $correo, $clave, $rol)) {
        echo "<script>
                alert('Registro exitoso');
                window.location.href = '../controlador/GestionarUsuariosControlador.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Hubo un error al registrar el usuario');</script>";
    }
}
?>
