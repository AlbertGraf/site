<?php
require_once __DIR__ . '/../config/config.php';

class EntregaApoyoModelo {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerProgramasActivos() {
        $stmt = $this->conn->prepare("SELECT id_programa, nombre_programa FROM programas_sociales WHERE status = 'Activo'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEntregasFiltradas($id_programa, $consulta) {
        $query = "
            SELECT rb.id_beneficiario, rb.id_programa, b.nombre, b.apellido_paterno, b.apellido_materno, 
                   b.direccion, b.colonia, b.alcaldia, b.correo,
                   ps.nombre_programa, rb.fecha_asignacion, rb.status_entrega
            FROM Registros_Beneficiarios rb
            JOIN Beneficiarios b ON rb.id_beneficiario = b.id_beneficiario
            JOIN Programas_Sociales ps ON rb.id_programa = ps.id_programa
            WHERE rb.status_entrega = 'En espera'
        ";
    
        $params = [];
    
        if (!empty($id_programa)) {
            $query .= " AND rb.id_programa = ?";
            $params[] = $id_programa;
        }
    
        if (!empty($consulta)) {
            $query .= " AND CONCAT(b.nombre, ' ', b.apellido_paterno, ' ', b.apellido_materno) LIKE ?";
            $params[] = "%$consulta%";
        }
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function marcarComoEntregado($id_beneficiario, $id_programa) {
        $stmt = $this->conn->prepare("UPDATE Registros_Beneficiarios SET status_entrega = 'Entregado' WHERE id_beneficiario = ? AND id_programa = ?");
        return $stmt->execute([$id_beneficiario, $id_programa]);
    }
}
?>
