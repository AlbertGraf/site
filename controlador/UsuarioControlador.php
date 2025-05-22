<?php
session_start();
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

class UsuarioControlador {
    private $usuarioModelo;

    public function __construct($conn) {
        $this->usuarioModelo = new UsuarioModelo($conn);
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $correo = trim($_POST["correo"] ?? "");
            $clave = trim($_POST["clave"] ?? "");

            $usuario = $this->usuarioModelo->verificarCredenciales($correo, $clave);

            if ($usuario) {
                $_SESSION["id_usuario"] = $usuario["id_usuario"];
                $_SESSION["rol"] = $usuario["rol"];

                if ($usuario['rol'] === 'administrador') {
                    header("Location: ../controlador/DashboardControlador.php?dashboard=admin");
                } else {
                    header("Location: ../controlador/DashboardControlador.php?dashboard=usuario");
                }
                exit();
            } else {
                $error_message = "Correo o contraseña incorrectos.";
                header("Location: ../vista/inicio.html?error=" . urlencode($error_message));
                exit();
            }
        }
    }
}

// Crear instancia del controlador y llamar al método login
require_once __DIR__ . '/../config/config.php';
$controlador = new UsuarioControlador($conn);
$controlador->login();
?>