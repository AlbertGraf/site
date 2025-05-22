<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/BeneficiarioProgramaModelo.php';

header('Content-Type: text/plain; charset=UTF-8'); // Definir tipo de contenido

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_beneficiario']) && isset($_POST['id_programa'])) {
    $id_beneficiario = $_POST['id_beneficiario'];
    $id_programa = $_POST['id_programa'];

    $beneficiarioProgramaModelo = new BeneficiarioProgramaModelo($conn);
    $resultado = $beneficiarioProgramaModelo->registrarBeneficiarioEnPrograma($id_beneficiario, $id_programa);

    echo $resultado;
}
?>
