<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de la Alcaldía Tláhuac</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

    <header class="admin-header">
        <h2>Reportes de la Alcaldía Tláhuac</h2>
    </header>

    <main class="contenedor">
        
        <section class="contenedor-botonera">
            <form action="/alcaldia/controlador/GenerarReporteControlador.php" method="get">
                <button type="submit" class="btn-accion">Generar Reporte</button>
            </form>

            <form action="/alcaldia/controlador/DashboardControlador.php" method="get">
                <input type="hidden" name="dashboard" value="admin">
                <button type="submit" class="btn-accion">Regresar al Menú Principal</button>
            </form>
        </section>

    </main>

</body>
</html>


