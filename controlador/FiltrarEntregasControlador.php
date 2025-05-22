<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/EntregaApoyoModelo.php';

header('Content-Type: text/html; charset=UTF-8'); // Definir tipo de contenido

$entregaApoyoModelo = new EntregaApoyoModelo($conn);

$id_programa = isset($_POST['id_programa']) ? $_POST['id_programa'] : '';
$consulta = isset($_POST['consulta']) ? $_POST['consulta'] : '';

$registros = $entregaApoyoModelo->obtenerEntregasFiltradas($id_programa, $consulta);

if (count($registros) > 0) {
    foreach ($registros as $registro) {
        $nombre_completo = htmlspecialchars($registro['nombre']) . " " .
                           htmlspecialchars($registro['apellido_paterno']) . " " .
                           htmlspecialchars($registro['apellido_materno']);
        echo "<tr id='fila_{$registro['id_beneficiario']}_{$registro['id_programa']}'>";
        echo "<td>$nombre_completo</td>";
        echo "<td>" . htmlspecialchars($registro['correo']) . "</td>";
        echo "<td>" . htmlspecialchars($registro['direccion']) . "</td>";
        echo "<td>" . htmlspecialchars($registro['colonia']) . "</td>";
        echo "<td>" . htmlspecialchars($registro['alcaldia']) . "</td>";
        echo "<td>" . htmlspecialchars($registro['nombre_programa']) . "</td>";
        echo "<td>" . htmlspecialchars($registro['fecha_asignacion']) . "</td>";
        echo "<td id='status_{$registro['id_beneficiario']}_{$registro['id_programa']}'>" . htmlspecialchars($registro['status_entrega']) . "</td>";
        echo "<td><button onclick='marcarEntregado({$registro['id_beneficiario']}, {$registro['id_programa']})'>Marcar como Entregado</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No se encontraron resultados</td></tr>";
}
?>
