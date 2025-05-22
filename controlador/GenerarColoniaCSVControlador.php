<?php
require_once __DIR__ . '/../config/config.php';
session_start();

// Verificar si se recibió el parámetro correcto
if (!isset($_GET['id_colonia'])) {
    die("Colonia no especificada.");
}

$colonia = $_GET['id_colonia'];

// Consulta para obtener los beneficiarios de la colonia seleccionada
$query = "
    SELECT B.nombre, B.apellido_paterno, B.apellido_materno, B.direccion, B.colonia, B.edad, B.sexo, P.nombre_programa  
    FROM Beneficiarios B
    LEFT JOIN Registros_Beneficiarios R ON B.id_beneficiario = R.id_beneficiario
    LEFT JOIN Programas_Sociales P ON R.id_programa = P.id_programa
    WHERE B.colonia = ?
";

$stmt = $conn->prepare($query);
$stmt->execute([$colonia]);
$beneficiarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$beneficiarios) {
    die("No hay beneficiarios en esta colonia.");
}

// Definir el nombre del archivo CSV
$filename = "Reporte_Beneficiarios_Colonia_" . str_replace(" ", "_", $colonia) . ".csv";

// Configurar encabezados HTTP para descarga
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Abrir salida en modo escritura
$output = fopen('php://output', 'w');

// Agregar encabezados al CSV
$headers = ['Nombre', 'Domicilio', 'Colonia', 'Edad', 'Sexo', 'Programa Social'];
fputcsv($output, $headers, ';'); // Usar `;` como delimitador para evitar problemas con comas en los campos

// Insertar los datos de los beneficiarios
foreach ($beneficiarios as $beneficiario) {
    $nombre_completo = "{$beneficiario['nombre']} {$beneficiario['apellido_paterno']} {$beneficiario['apellido_materno']}";
    $programa_social = $beneficiario['nombre_programa'] ?? 'Sin programa';

    fputcsv($output, [
        $nombre_completo,
        $beneficiario['direccion'],
        $beneficiario['colonia'],
        $beneficiario['edad'],
        $beneficiario['sexo'],
        $programa_social
    ], ';');
}

// Cerrar el archivo CSV
fclose($output);
exit;
?>
