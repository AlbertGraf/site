<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/BeneficiarioProgramaModelo.php';

header('Content-Type: text/html; charset=UTF-8'); // Definir tipo de contenido

$beneficiarioProgramaModelo = new BeneficiarioProgramaModelo($conn);
$programas = $beneficiarioProgramaModelo->obtenerProgramasActivosAjax();

$options = "";
foreach ($programas as $programa) {
    $options .= "<option value='" . htmlspecialchars($programa['id_programa']) . "'>" . htmlspecialchars($programa['nombre_programa']) . "</option>";
}

echo $options;
?>
