<?php
require_once __DIR__ . '/../config/config.php';

class ReportesModelo {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todos los reportes
    public function obtenerReportes() {
        $stmt = $this->conn->prepare("
            SELECT r.id_reporte, u.nombre AS usuario, r.nombre_reporte, r.fecha_generacion, r.formato
            FROM Reportes r
            LEFT JOIN Usuarios u ON r.id_usuario = u.id_usuario
            ORDER BY r.fecha_generacion DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener la lista de programas sociales
    public function obtenerProgramas() {
        $stmt = $this->conn->query("SELECT id_programa, nombre_programa, descripcion, status FROM Programas_Sociales");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registrar un nuevo reporte en la base de datos
    public function registrarReporte($id_usuario, $nombre_reporte, $formato) {
        $stmt = $this->conn->prepare("INSERT INTO Reportes (id_usuario, nombre_reporte, formato) VALUES (?, ?, ?)");
        $stmt->execute([$id_usuario, $nombre_reporte, $formato]);
        return $this->conn->lastInsertId(); // Devolver el ID del reporte registrado
    }

    // Obtener beneficiarios inscritos en un programa social específico
    public function obtenerBeneficiariosPorPrograma($id_programa) {
        $stmt = $this->conn->prepare("
            SELECT B.nombre, B.apellido_paterno, B.apellido_materno, B.direccion, B.colonia, B.edad, P.nombre_programa 
            FROM Beneficiarios B
            INNER JOIN Registros_Beneficiarios R ON B.id_beneficiario = R.id_beneficiario
            INNER JOIN Programas_Sociales P ON R.id_programa = P.id_programa
            WHERE P.id_programa = ?
        ");
        $stmt->execute([$id_programa]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todas las colonias donde hay beneficiarios registrados
    public function obtenerColoniasConBeneficiarios() {
        $stmt = $this->conn->query("SELECT DISTINCT colonia FROM Beneficiarios ORDER BY colonia ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener beneficiarios de una colonia específica
    public function obtenerBeneficiariosPorColonia($colonia) {
        $stmt = $this->conn->prepare("SELECT nombre, direccion, colonia, edad FROM Beneficiarios WHERE colonia = ?");
        $stmt->execute([$colonia]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerBeneficiariosPorGenero($genero) {
        $query = "
            SELECT B.nombre, B.apellido_paterno, B.apellido_materno, B.direccion, 
                   B.colonia, B.edad, B.sexo, P.nombre_programa  
            FROM Beneficiarios B
            INNER JOIN Registros_Beneficiarios R ON B.id_beneficiario = R.id_beneficiario
            INNER JOIN Programas_Sociales P ON R.id_programa = P.id_programa
            WHERE B.sexo = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$genero]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerReportesParaExportar() {
        $stmt = $this->conn->query("
            SELECT r.id_reporte, u.nombre AS usuario, r.nombre_reporte, r.fecha_generacion, r.formato
            FROM Reportes r
            LEFT JOIN Usuarios u ON r.id_usuario = u.id_usuario
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>