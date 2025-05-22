<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reportes</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

    <header class="admin-header">
        <h2>Lista de Reportes</h2>
    </header>

    <main class="contenedor">

        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Nombre del Reporte</th>
                    <th>Fecha de Generación</th>
                    <th>Formato</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportes as $reporte): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reporte['id_reporte']); ?></td>
                        <td><?php echo htmlspecialchars($reporte['usuario'] ?? 'Desconocido'); ?></td>
                        <td><?php echo htmlspecialchars($reporte['nombre_reporte']); ?></td>
                        <td><?php echo htmlspecialchars($reporte['fecha_generacion']); ?></td>
                        <td><?php echo htmlspecialchars($reporte['formato']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <br>
<div class="contenedor-botonera">
        <form action="/alcaldia/controlador/ReportesControlador.php" method="get" class="form-inline">
            <button type="submit" class="btn-accion btn-secundario">Regresar</button>
        </form>
</div>
    </main>

</body>
</html>
