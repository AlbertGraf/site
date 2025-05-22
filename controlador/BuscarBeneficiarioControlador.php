<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/BeneficiarioModelo.php';

header('Content-Type: text/html; charset=UTF-8');  // Asegurar codificación correcta

$beneficiarioModelo = new BeneficiarioModelo($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consulta'])) {
    $consulta = trim($_POST['consulta']);

    if (!empty($consulta)) {
        $beneficiarios = $beneficiarioModelo->buscarBeneficiarios($consulta);

        if (count($beneficiarios) > 0) {
            foreach ($beneficiarios as $beneficiario) {
                $id = htmlspecialchars($beneficiario['id_beneficiario']);
                $nombre_completo = htmlspecialchars($beneficiario['nombre']) . " " . 
                                htmlspecialchars($beneficiario['apellido_paterno']) . " " . 
                                htmlspecialchars($beneficiario['apellido_materno']);

                function getFileLink($file, $label) {
                    return !empty($file) ? "<a href='/alcaldia/uploads/" . htmlspecialchars(basename($file)) . "' target='_blank'>$label</a>" : "No disponible";
                }

                $curp_pdf = getFileLink($beneficiario['curp_pdf'], 'Ver CURP');
                $acta_pdf = getFileLink($beneficiario['acta_nacimiento_pdf'], 'Ver Acta');
                $comprobante_pdf = getFileLink($beneficiario['comprobante_domicilio_pdf'], 'Ver Comprobante');

                echo "<tr>
                        <td>$nombre_completo</td>
                        <td>" . htmlspecialchars($beneficiario['direccion']) . "</td>
                        <td>" . htmlspecialchars($beneficiario['colonia']) . "</td>
                        <td>" . htmlspecialchars($beneficiario['edad']) . "</td>
                        <td>" . htmlspecialchars($beneficiario['correo']) . "</td>
                        <td>" . htmlspecialchars($beneficiario['telefono']) . "</td>
                        <td>$curp_pdf</td>
                        <td>$acta_pdf</td>
                        <td>$comprobante_pdf</td>
                        <td>
                            <form action='/alcaldia/controlador/ActualizarBeneficiarioControlador.php' method='get' style='margin: 0;'>
                                <input type='hidden' name='id_beneficiario' value='$id'>
                                <button type='submit'>Actualizar</button>
                            </form>
                        </td>
                        <td>
                            <button onclick=\"confirmarEliminacion($id, '$nombre_completo')\">Eliminar</button>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No se encontraron resultados</td></tr>";
            echo "<tr><td colspan='11'>
                  
                  </td></tr>";
        }
    } else {
        echo "<tr><td colspan='11'>Escribe un nombre para buscar</td></tr>";
        echo "<tr><td colspan='11'>
                
              </td></tr>";
    }
} else {
    echo "<tr><td colspan='11'>Error en la solicitud</td></tr>";
    echo "<tr><td colspan='11'>
            <form action='/alcaldia/controlador/GestionarBeneficiariosControlador.php' method='get' style='text-align: center; margin-top: 10px;'>
                <button type='submit'>Regresar</button>
            </form>
          </td></tr>";
}
?>
