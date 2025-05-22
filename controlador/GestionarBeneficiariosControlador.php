<?php
session_start();

// Verificar si el usuario tiene sesión activa y el rol está definido
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    header('Location: ../vista/inicio.html');
    exit();
}

// Determinar qué vista cargar según el rol del usuario
$rutas_vistas = [
    'administrador' => __DIR__ . '/../vista/admin/gestionar_beneficiarios.php',
    'usuario' => __DIR__ . '/../vista/usuario/gestionar_beneficiarios.php'
];

// Verificar si el rol tiene una vista asignada y cargarla
if (array_key_exists($_SESSION['rol'], $rutas_vistas)) {
    require_once $rutas_vistas[$_SESSION['rol']];
} else {
    die("Error: El rol '{$_SESSION['rol']}' no tiene acceso a esta página");
}
?>
