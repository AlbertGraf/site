<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Respaldo de la base de datos</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

    <header class="admin-header">
        <h1>Respaldo de la base de datos de la Alcaldía Tláhuac</h1>
    </header>

    <main class="contenedor">

        <table class="tabla sombra">
            <thead>
                <tr>
                    <th>Exportar</th>
                    <th>Formato XLS</th>
                    <th>Formato CSV</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Usuarios</td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarUsuariosControlador.php" method="get">
                            <button type="submit" name="formato" value="xls" class="btn-accion">XLS</button>
                        </form>
                    </td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarUsuariosControlador.php" method="get">
                            <button type="submit" name="formato" value="csv" class="btn-accion btn-secundario">CSV</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>Programas Sociales</td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarProgramasControlador.php" method="get">
                            <button type="submit" name="formato" value="xls" class="btn-accion">XLS</button>
                        </form>
                    </td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarProgramasControlador.php" method="get">
                            <button type="submit" name="formato" value="csv" class="btn-accion btn-secundario">CSV</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>Beneficiarios</td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarBeneficiariosControlador.php" method="get">
                            <button type="submit" name="formato" value="xls" class="btn-accion">XLS</button>
                        </form>
                    </td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarBeneficiariosControlador.php" method="get">
                            <button type="submit" name="formato" value="csv" class="btn-accion btn-secundario">CSV</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>Beneficiario-Programa Social</td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarBeneficiarioProgramaControlador.php" method="get">
                            <button type="submit" name="formato" value="xls" class="btn-accion">XLS</button>
                        </form>
                    </td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarBeneficiarioProgramaControlador.php" method="get">
                            <button type="submit" name="formato" value="csv" class="btn-accion btn-secundario">CSV</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>Reportes</td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarReportesControlador.php" method="get">
                            <button type="submit" name="formato" value="xls" class="btn-accion">XLS</button>
                        </form>
                    </td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarReportesControlador.php" method="get">
                            <button type="submit" name="formato" value="csv" class="btn-accion btn-secundario">CSV</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td><strong>Base de Datos (Completa)</strong></td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarBaseCompletaControlador.php" method="get">
                            <button type="submit" name="formato" value="xls" class="btn-accion">XLS</button>
                        </form>
                    </td>
                    <td>
                        <form action="/alcaldia/controlador/ExportarBaseCompletaControlador.php" method="get">
                            <button type="submit" name="formato" value="csv" class="btn-accion btn-secundario">CSV</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <br><br>
        <div class="contenedor-botonera">
        <form action="/alcaldia/controlador/DashboardControlador.php" method="get" class="form-inline">
            <input type="hidden" name="dashboard" value="admin">
            <button type="submit" class="btn-accion btn-secundario">Regresar al Menú principal</button>
        </form>
        </div>
    </main>

</body>
</html>
