<?php
require_once __DIR__ . '/../config/config.php';

class RespaldoModelo {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener datos de una tabla específica
    public function obtenerDatosTabla($tabla) {
        $stmt = $this->conn->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener lista de todas las tablas a respaldar
    public function obtenerTablas() {
        return ["Usuarios", "Programas_Sociales", "Beneficiarios", "Registros_Beneficiarios", "Reportes"];
    }
}
?>
