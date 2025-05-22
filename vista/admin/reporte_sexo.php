<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte por Género</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

    <header class="admin-header">
        <h2>Generar Reporte por Género</h2>
    </header>

    <main class="contenedor">

        <form action="/alcaldia/controlador/ProcesoReporteSexoControlador.php" method="POST" class="formulario">
            <div class="form-group">
                <label for="genero">Seleccione el género:</label>
                <select name="genero" id="genero" required class="select-formato">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="formato">Seleccione el formato:</label>
                <select name="formato" id="formato" required class="select-formato">
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
