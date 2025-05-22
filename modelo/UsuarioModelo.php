<?php
require_once __DIR__ . '/../config/config.php';

class UsuarioModelo {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function verificarCredenciales($correo, $clave) {
        $stmt = $this->conn->prepare("SELECT id_usuario, clave, rol FROM Usuarios WHERE correo = :correo AND clave = :clave");
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":clave", $clave);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerUsuarioPorId($id_usuario) {
        $stmt = $this->conn->prepare("SELECT * FROM Usuarios WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Depuración: Registrar en el log si no se encuentra usuario
        if (!$usuario) {
            error_log("MODELO USUARIO: No se encontró el usuario con ID " . $id_usuario);
        }
    
        return $usuario;
    }
    

    public function obtenerUsuarios($id_usuario_sesion) {
        $stmt = $this->conn->prepare("SELECT id_usuario, nombre, correo, clave, rol FROM Usuarios WHERE id_usuario != :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario_sesion);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Debugging: Registrar en el log si no hay usuarios
        if (empty($usuarios)) {
            error_log("GESTIONAR USUARIOS: La consulta no devolvió registros.");
        } else {
            error_log("GESTIONAR USUARIOS: Se encontraron " . count($usuarios) . " usuarios.");
        }

        return $usuarios;
    }

    public function registrarUsuario($id_usuario, $nombre, $correo, $clave, $rol) {
        $stmt = $this->conn->prepare("INSERT INTO Usuarios (id_usuario, nombre, correo, clave, rol) VALUES (:id_usuario, :nombre, :correo, :clave, :rol)");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':rol', $rol);

        return $stmt->execute();
    }

    public function actualizarUsuario($id_usuario, $nombre, $correo, $clave, $rol) {
        $stmt = $this->conn->prepare("UPDATE Usuarios 
                                      SET nombre = :nombre, correo = :correo, clave = :clave, rol = :rol 
                                      WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':rol', $rol);

        return $stmt->execute();
    }

    public function eliminarUsuario($id_usuario) {
        $stmt = $this->conn->prepare("DELETE FROM Usuarios WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario);
        return $stmt->execute();
    }

    public function exportarUsuarios() {
        $stmt = $this->conn->prepare("SELECT * FROM Usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
?>

