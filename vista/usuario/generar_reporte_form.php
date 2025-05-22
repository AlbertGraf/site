<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Tipo de Reporte</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

    <header class="admin-header">
        <h2>Seleccionar Tipo de Reporte</h2>
    </header>

    <main class="contenedor">

        <form id="reporteForm" class="formulario">
            <div class="form-group">
                <label for="nombre_reporte">Seleccione el tipo de reporte:</label>
                <select name="nombre_reporte" id="nombre_reporte" required>
                    <option value="/alcaldia/controlador/ReporteProgramaControlador.php">Programa Social</option>
                    <option value="/alcaldia/controlador/ReporteColoniaControlador.php">Colonia</option>
                    <option value="/alcaldia/controlador/ReporteSexoControlador.php">Género</option>
                </select>
            </div>

            <button type="submit" class="btn-accion">Continuar</button>
        </form>

        <br>
        <div class="contenedor-botonera">
        <form action="/alcaldia/controlador/ReportesControlador.php" method="get" class="form-inline">
            <button type="submit" class="btn-accion btn-secundario">Regresar</button>
        </form>
        </div>
    </main>

    <script>
        document.getElementById("reporteForm").addEventListener("submit", function(event) {
            event.preventDefault();
            let selectedPage = document.getElementById("nombre_reporte").value;
            window.location.href = selectedPage;
        });
    </script>

</body>
</html>
