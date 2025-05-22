<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../modelo/EntregaApoyoModelo.php';

header('Content-Type: text/plain; charset=UTF-8'); // Definir tipo de contenido

$entregaApoyoModelo = new EntregaApoyoModelo($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_beneficiario']) && isset($_POST['id_programa'])) {
    $id_beneficiario = $_POST['id_beneficiario'];
    $id_programa = $_POST['id_programa'];

    if ($entregaApoyoModelo->marcarComoEntregado($id_beneficiario, $id_programa)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid_request";
}
?>
