<?php
session_start();
require_once __DIR__ . '/../modelo/UsuarioModelo.php';
require_once __DIR__ . '/../config/config.php';

// Verificar si el usuario tiene sesión activa
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../vista/inicio.html');
    exit();
}

// Protección contra secuestro de sesión (Session Hijacking)
if (!isset($_SESSION['user_agent'])) {
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
} elseif ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_destroy();
    header('Location: ../vista/inicio.html');
    exit();
}

// Manejo de tiempo de inactividad (Session Timeout)
$timeout = 1800; // 30 minutos
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
    header('Location: ../vista/inicio.html');
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // Renovar sesión

// Obtener información del usuario
$usuarioModelo = new UsuarioModelo($conn);
$id_usuario = $_SESSION['id_usuario'];
$usuario = $usuarioModelo->obtenerUsuarioPorId($id_usuario);

if (!$usuario) {
    header('Location: ../vista/inicio.html');
    exit();
}

$nombre_usuario = htmlspecialchars($usuario['nombre']);

// Determinar qué dashboard cargar según el rol
switch ($_SESSION['rol']) {
    case 'administrador':
        include __DIR__ . '/../vista/admin/dashboard_admin.php';
        break;
    case 'usuario':
        include __DIR__ . '/../vista/usuario/dashboard_usuario.php';
        break;
    default:
        header('Location: ../vista/inicio.html');
        exit();
}
?>