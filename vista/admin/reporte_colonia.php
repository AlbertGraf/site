<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte - Beneficiarios por Colonia</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

    <header class="admin-header">
        <h2>Reporte de Beneficiarios por Colonia</h2>
    </header>

    <main class="contenedor">

        <form action="/alcaldia/controlador/ProcesoRegistroColoniaControlador.php" method="POST" class="formulario">
            <div class="form-group">
                <label for="colonia">Seleccione una colonia:</label>
                <select id="colonia" name="colonia" required class="select-formato">
                    <option value="">-- Seleccionar --</option>
                    <?php foreach ($colonias as $colonia): ?>
                        <option value="<?= htmlspecialchars($colonia['colonia']) ?>">
                            <?= htmlspecialchars($colonia['colonia']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="formato">Seleccione el formato del reporte:</label>
                <select id="formato" name="formato" required class="select-formato">
                    <option value="PDF">PDF</option>
                    <option value="CSV">CSV</option>
                    <option value="XLS">XLS</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-accion">Generar Reporte</button>
            </div>
        </form>
                        <div class="contenedor-botonera">
        <form action="/alcaldia/controlador/GenerarReporteControlador.php" method="get" class="form-inline">
            <button type="submit" class="btn-accion btn-secundario">Regresar</button>
        </form>
                    </div>
    </main>

</body>
</html>
