<?php
require_once __DIR__ . '/../config/config.php';

class ProgramaModelo {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todos los programas sociales
    public function obtenerProgramas() {
        $stmt = $this->conn->query("SELECT * FROM programas_sociales");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar el estado de los programas basado en la fecha actual
    public function actualizarEstadosProgramas() {
        $fecha_actual = date('Y-m-d');
        $stmt = $this->conn->query("SELECT id_programa, fecha_inicio, fecha_fin FROM programas_sociales");
        $programas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($programas as $programa) {
            $nuevo_status = ($fecha_actual >= $programa['fecha_inicio'] && $fecha_actual <= $programa['fecha_fin']) 
                ? 'Activo' 
                : 'Inactivo';

            $update_stmt = $this->conn->prepare("UPDATE programas_sociales SET status = :status WHERE id_programa = :id");
            $update_stmt->bindParam(':status', $nuevo_status);
            $update_stmt->bindParam(':id', $programa['id_programa']);
            $update_stmt->execute();
        }
    }
    public function registrarPrograma($id_programa, $nombre, $descripcion, $fecha_inicio, $fecha_fin) {
        $fecha_actual = date('Y-m-d');
    
        $status = ($fecha_actual < $fecha_inicio) ? 'Inactivo' 
                 : (($fecha_actual >= $fecha_inicio && $fecha_actual <= $fecha_fin) ? 'Activo' 
                 : 'Inactivo');
    
        $stmt = $this->conn->prepare("INSERT INTO programas_sociales (id_programa, nombre_programa, descripcion, fecha_inicio, fecha_fin, status)
                                      VALUES (:id_programa, :nombre, :descripcion, :fecha_inicio, :fecha_fin, :status)");
    
        $stmt->bindParam(':id_programa', $id_programa);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':status', $status);
    
        return $stmt->execute();
    }

    public function obtenerProgramaPorId($id_programa) {
        $stmt = $this->conn->prepare("SELECT * FROM programas_sociales WHERE id_programa = :id_programa");
        $stmt->bindParam(':id_programa', $id_programa, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function actualizarPrograma($id_programa, $nombre, $descripcion, $fecha_inicio, $fecha_fin) {
        $stmt = $this->conn->prepare("UPDATE programas_sociales 
                                      SET nombre_programa = :nombre, 
                                          descripcion = :descripcion, 
                                          fecha_inicio = :fecha_inicio, 
                                          fecha_fin = :fecha_fin 
                                      WHERE id_programa = :id_programa");
    
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':id_programa', $id_programa, PDO::PARAM_INT);
    
        return $stmt->execute();
    }

    public function eliminarPrograma($id_programa) {
        $stmt = $this->conn->prepare("DELETE FROM programas_sociales WHERE id_programa = :id_programa");
        $stmt->bindParam(':id_programa', $id_programa, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function importarProgramaDesdeCSV($archivo_csv) {
        if (($gestor = fopen($archivo_csv, "r")) !== FALSE) {
            $columnas = fgetcsv($gestor); // Leer encabezados
            $datos = fgetcsv($gestor); // Leer datos
    
            if ($datos) {
                // Construir consulta de inserción
                $query = "INSERT INTO programas_sociales (" . implode(", ", $columnas) . ") VALUES (:" . implode(", :", $columnas) . ")";
                $stmt = $this->conn->prepare($query);
    
                // Bind de valores
                foreach ($columnas as $index => $columna) {
                    $stmt->bindValue(":$columna", $datos[$index]);
                }
    
                $resultado = $stmt->execute();
                fclose($gestor);
    
                // Eliminar el archivo después de importarlo
                unlink($archivo_csv);
    
                return $resultado;
            }
        }
        return false;
    }

    public function obtenerProgramasParaExportar() {
        $stmt = $this->conn->query("SELECT id_programa, nombre_programa, descripcion, fecha_inicio, fecha_fin, status FROM programas_sociales");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>