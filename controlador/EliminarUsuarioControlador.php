<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

// Verificar que el usuario tenga sesión activa y sea administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ../vista/inicio.html');
    exit();
}

$usuarioModelo = new UsuarioModelo($conn);

// Verificar si se recibe el ID del usuario a eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];

    // Evitar que un usuario se elimine a sí mismo
    if ($id_usuario == $_SESSION['id_usuario']) {
        echo "<script>
                alert('No puedes eliminar el usuario con el que estás logueado.');
                window.location.href = '../controlador/GestionarUsuariosControlador.php';
              </script>";
        exit();
    }

    // Eliminar usuario
    if ($usuarioModelo->eliminarUsuario($id_usuario)) {
        echo "<script>
                alert('Usuario eliminado satisfactoriamente');
                window.location.href = '../controlador/GestionarUsuariosControlador.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error al eliminar el usuario');
                window.location.href = '../controlador/GestionarUsuariosControlador.php';
              </script>";
        exit();
    }
} else {
    header('Location: ../controlador/GestionarUsuariosControlador.php');
    exit();
}
?>
