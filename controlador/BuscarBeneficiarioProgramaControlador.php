<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/BeneficiarioProgramaModelo.php';

header('Content-Type: text/html; charset=UTF-8'); // Definir tipo de contenido

$beneficiarioProgramaModelo = new BeneficiarioProgramaModelo($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consulta'])) {
    $consulta = trim($_POST['consulta']);

    if (!empty($consulta)) {
        $beneficiarios = $beneficiarioProgramaModelo->buscarBeneficiariosPorNombre($consulta);

        if (count($beneficiarios) > 0) {
            foreach ($beneficiarios as $beneficiario) {
                $id_beneficiario = htmlspecialchars($beneficiario['id_beneficiario']);
                $nombre_completo = htmlspecialchars($beneficiario['nombre']) . " " . 
                                   htmlspecialchars($beneficiario['apellido_paterno']) . " " . 
                                   htmlspecialchars($beneficiario['apellido_materno']);

                echo "<tr>";
                echo "<td>$nombre_completo</td>";
                echo "<td>" . htmlspecialchars($beneficiario['correo']) . "</td>";
                echo "<td>" . htmlspecialchars($beneficiario['edad']) . "</td>";
                echo "<td>" . htmlspecialchars($beneficiario['direccion']) . "</td>";
                echo "<td>" . htmlspecialchars($beneficiario['colonia']) . "</td>";
                echo "<td>" . htmlspecialchars($beneficiario['alcaldia']) . "</td>";
                echo "<td>" . htmlspecialchars($beneficiario['sexo']) . "</td>";
                echo "<td><button onclick='abrirModal($id_beneficiario)'>Registrar</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No se encontraron resultados</td></tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Escribe un nombre para buscar</td></tr>";
    }
} else {
    echo "<tr><td colspan='8'>Error en la solicitud</td></tr>";
}
?>
