<?php
require_once __DIR__ . '/../config/config.php';

class BeneficiarioProgramaModelo {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerProgramasActivos() {
        $stmt = $this->conn->prepare("SELECT id_programa, nombre_programa, descripcion, fecha_inicio, fecha_fin, 
                                             DATEDIFF(fecha_fin, fecha_inicio) AS dias_duracion, status 
                                      FROM programas_sociales 
                                      WHERE status = 'Activo'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerBeneficiarios() {
        $stmt = $this->conn->prepare("SELECT * FROM Beneficiarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProgramasActivosAjax() {
        $stmt = $this->conn->prepare("SELECT id_programa, nombre_programa FROM programas_sociales WHERE status = 'Activo'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarBeneficiarioEnPrograma($id_beneficiario, $id_programa) {
        // Verificar si el beneficiario ya está inscrito
        $stmt = $this->conn->prepare("SELECT * FROM Registros_Beneficiarios WHERE id_beneficiario = ? AND id_programa = ?");
        $stmt->execute([$id_beneficiario, $id_programa]);
    
        if ($stmt->rowCount() > 0) {
            return "El beneficiario ya está inscrito en este programa.";
        }
    
        // Insertar la nueva relación
        $stmt = $this->conn->prepare("INSERT INTO Registros_Beneficiarios (id_beneficiario, id_programa) VALUES (?, ?)");
        if ($stmt->execute([$id_beneficiario, $id_programa])) {
            return "Beneficiario inscrito en el programa correctamente.";
        } else {
            return "Error al registrar al beneficiario.";
        }
    }
    public function buscarBeneficiariosPorNombre($consulta) {
        $stmt = $this->conn->prepare("
            SELECT id_beneficiario, nombre, apellido_paterno, apellido_materno, direccion, colonia, edad, correo, sexo, alcaldia
            FROM Beneficiarios 
            WHERE CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE :consulta
            ORDER BY nombre ASC
        ");    
    
        $param = "%$consulta%";
        $stmt->bindParam(':consulta', $param, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerBeneficiariosProgramasParaExportar() {
        $stmt = $this->conn->query("
            SELECT rb.id_beneficiario, b.nombre AS nombre_beneficiario, b.apellido_paterno, b.apellido_materno,
                   rb.id_programa, p.nombre_programa, rb.fecha_asignacion, rb.status_entrega
            FROM Registros_Beneficiarios rb
            JOIN Beneficiarios b ON rb.id_beneficiario = b.id_beneficiario
            JOIN Programas_Sociales p ON rb.id_programa = p.id_programa
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
