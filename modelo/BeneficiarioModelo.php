<?php
require_once __DIR__ . '/../config/config.php';

class BeneficiarioModelo {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registrarBeneficiario($datos, $archivos) {
        // Crear directorio de uploads si no existe
        $directorio_destino = __DIR__ . '/../uploads/';
        if (!is_dir($directorio_destino)) {
            mkdir($directorio_destino, 0777, true);
        }

        // Guardar archivos PDF
        $curp_pdf = $directorio_destino . basename($archivos["curp_pdf"]["name"]);
        $acta_pdf = $directorio_destino . basename($archivos["acta_nacimiento_pdf"]["name"]);
        $comprobante_pdf = $directorio_destino . basename($archivos["comprobante_domicilio_pdf"]["name"]);

        if (move_uploaded_file($archivos["curp_pdf"]["tmp_name"], $curp_pdf) &&
            move_uploaded_file($archivos["acta_nacimiento_pdf"]["tmp_name"], $acta_pdf) &&
            move_uploaded_file($archivos["comprobante_domicilio_pdf"]["tmp_name"], $comprobante_pdf)) {

            // Insertar beneficiario en la base de datos
            $stmt = $this->conn->prepare("INSERT INTO Beneficiarios 
                (nombre, apellido_paterno, apellido_materno, edad, sexo, direccion, colonia, alcaldia, telefono, correo, curp_pdf, acta_nacimiento_pdf, comprobante_domicilio_pdf, codigo_postal) 
                VALUES (:nombre, :apellido_paterno, :apellido_materno, :edad, :sexo, :direccion, :colonia, 'Tláhuac', :telefono, :correo, :curp_pdf, :acta_pdf, :comprobante_pdf, :codigo_postal)");

            $stmt->bindParam(':nombre', $datos['nombre']);
            $stmt->bindParam(':apellido_paterno', $datos['apellido_paterno']);
            $stmt->bindParam(':apellido_materno', $datos['apellido_materno']);
            $stmt->bindParam(':edad', $datos['edad']);
            $stmt->bindParam(':sexo', $datos['sexo']);
            $stmt->bindParam(':direccion', $datos['direccion']);
            $stmt->bindParam(':colonia', $datos['colonia']);
            $stmt->bindParam(':telefono', $datos['telefono']);
            $stmt->bindParam(':correo', $datos['correo']);
            $stmt->bindParam(':curp_pdf', $curp_pdf);
            $stmt->bindParam(':acta_pdf', $acta_pdf);
            $stmt->bindParam(':comprobante_pdf', $comprobante_pdf);
            $stmt->bindParam(':codigo_postal', $datos['codigo_postal']);

            return $stmt->execute();
        }
        return false;
    }

    public function obtenerBeneficiarios() {
        $stmt = $this->conn->query("SELECT * FROM Beneficiarios ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarBeneficiarios($consulta) {
        $stmt = $this->conn->prepare("
            SELECT id_beneficiario, nombre, apellido_paterno, apellido_materno, 
                   direccion, colonia, edad, correo, telefono, 
                   curp_pdf, acta_nacimiento_pdf, comprobante_domicilio_pdf
            FROM Beneficiarios 
            WHERE CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE :consulta 
            ORDER BY nombre ASC
        ");    
    
        $param = "%$consulta%";
        $stmt->bindParam(':consulta', $param, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerBeneficiarioPorId($id_beneficiario) {
        $stmt = $this->conn->prepare("SELECT * FROM Beneficiarios WHERE id_beneficiario = :id_beneficiario");
        $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarBeneficiario($datos, $archivos) {
        $id_beneficiario = $datos['id_beneficiario'];

        // Obtener beneficiario actual para conservar archivos si no se actualizan
        $beneficiario_actual = $this->obtenerBeneficiarioPorId($id_beneficiario);
        if (!$beneficiario_actual) {
            return false;
        }

        // Directorio de uploads
        $directorio_destino = __DIR__ . '/../uploads/';

        // Manejo de archivos (conserva los existentes si no se suben nuevos)
        $curp_pdf = !empty($archivos['curp_pdf']['name']) ? $directorio_destino . basename($archivos["curp_pdf"]["name"]) : $beneficiario_actual['curp_pdf'];
        $acta_pdf = !empty($archivos['acta_nacimiento_pdf']['name']) ? $directorio_destino . basename($archivos["acta_nacimiento_pdf"]["name"]) : $beneficiario_actual['acta_nacimiento_pdf'];
        $comprobante_pdf = !empty($archivos['comprobante_domicilio_pdf']['name']) ? $directorio_destino . basename($archivos["comprobante_domicilio_pdf"]["name"]) : $beneficiario_actual['comprobante_domicilio_pdf'];

        // Mover archivos si se subieron nuevos
        if (!empty($archivos['curp_pdf']['tmp_name'])) {
            move_uploaded_file($archivos['curp_pdf']['tmp_name'], $curp_pdf);
        }
        if (!empty($archivos['acta_nacimiento_pdf']['tmp_name'])) {
            move_uploaded_file($archivos['acta_nacimiento_pdf']['tmp_name'], $acta_pdf);
        }
        if (!empty($archivos['comprobante_domicilio_pdf']['tmp_name'])) {
            move_uploaded_file($archivos['comprobante_domicilio_pdf']['tmp_name'], $comprobante_pdf);
        }

        // Actualizar beneficiario
        $stmt = $this->conn->prepare("UPDATE Beneficiarios 
            SET nombre = :nombre, apellido_paterno = :apellido_paterno, apellido_materno = :apellido_materno, 
                edad = :edad, sexo = :sexo, direccion = :direccion, colonia = :colonia, 
                telefono = :telefono, correo = :correo, curp_pdf = :curp_pdf, 
                acta_nacimiento_pdf = :acta_pdf, comprobante_domicilio_pdf = :comprobante_pdf 
            WHERE id_beneficiario = :id_beneficiario");

        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':apellido_paterno', $datos['apellido_paterno']);
        $stmt->bindParam(':apellido_materno', $datos['apellido_materno']);
        $stmt->bindParam(':edad', $datos['edad']);
        $stmt->bindParam(':sexo', $datos['sexo']);
        $stmt->bindParam(':direccion', $datos['direccion']);
        $stmt->bindParam(':colonia', $datos['colonia']);
        $stmt->bindParam(':telefono', $datos['telefono']);
        $stmt->bindParam(':correo', $datos['correo']);
        $stmt->bindParam(':curp_pdf', $curp_pdf);
        $stmt->bindParam(':acta_pdf', $acta_pdf);
        $stmt->bindParam(':comprobante_pdf', $comprobante_pdf);
        $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);

        return $stmt->execute();
    }
    public function eliminarBeneficiario($id_beneficiario) {
        // Obtener archivos relacionados con el beneficiario
        $stmt = $this->conn->prepare("SELECT curp_pdf, acta_nacimiento_pdf, comprobante_domicilio_pdf FROM Beneficiarios WHERE id_beneficiario = :id_beneficiario");
        $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
        $stmt->execute();
        $beneficiario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$beneficiario) {
            return false; // No se encontró el beneficiario
        }

        // Función para eliminar archivos
        function eliminarArchivo($ruta) {
            if (!empty($ruta) && file_exists(__DIR__ . '/../uploads/' . basename($ruta))) {
                unlink(__DIR__ . '/../uploads/' . basename($ruta));
            }
        }

        // Eliminar archivos del servidor
        eliminarArchivo($beneficiario['curp_pdf']);
        eliminarArchivo($beneficiario['acta_nacimiento_pdf']);
        eliminarArchivo($beneficiario['comprobante_domicilio_pdf']);

        // Eliminar beneficiario de la base de datos
        $stmt = $this->conn->prepare("DELETE FROM Beneficiarios WHERE id_beneficiario = :id_beneficiario");
        $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function obtenerBeneficiariosParaExportar() {
        $stmt = $this->conn->query("SELECT id_beneficiario, nombre, apellido_paterno, apellido_materno, edad, sexo, direccion, colonia, alcaldia, telefono, correo, fecha_registro, codigo_postal FROM Beneficiarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
    

