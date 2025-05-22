<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

// Verificar que el usuario esté autenticado y sea administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ../vista/inicio.html');
    exit();
}

try {
    // Crear instancia del modelo de usuario y obtener la lista de usuarios
    $usuarioModelo = new UsuarioModelo($conn);
    $id_usuario_sesion = $_SESSION['id_usuario'];
    $usuarios = $usuarioModelo->obtenerUsuarios($id_usuario_sesion);

    // Verificar si realmente se están obteniendo los usuarios
    if (empty($usuarios)) {
        error_log("GESTIONAR USUARIOS: No se encontraron usuarios en la base de datos.");
    }

    // Incluir la vista y pasarle los datos
    include __DIR__ . '/../vista/admin/gestionar_usuarios.php';

} catch (Exception $e) {
    die("Error al obtener los usuarios: " . $e->getMessage());
}
?>
