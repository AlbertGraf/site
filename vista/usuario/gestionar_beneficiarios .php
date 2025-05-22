<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Beneficiarios</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

    <h1>Gestión de Beneficiarios</h1>

    <table width="100%" border="0">
        <tr>
            <td width="50%" valign="top">
                <h3>¿Qué deseas hacer?</h3>
            </td>

            <td width="50%" valign="top">
                <form action="/alcaldia/vista/admin/registrar_beneficiario.php" method="get">
                    <button type="submit">Registrar Beneficiario</button>
                </form>

                <br>

                <form action="/alcaldia/controlador/GestionarBeneficiariosListaControlador.php" method="get">
                    <button type="submit">Consultar, Modificar o Eliminar Beneficiario</button>
                </form>

                <br>

                <form action="/alcaldia/controlador/RegistrarBeneficiarioProgramaControlador.php" method="get">
                    <button type="submit">Registrar Beneficiario a Programa Social</button>
                </form>
                
                <br>

                <form action="/alcaldia/controlador/EntregaApoyoControlador.php" method="get">
                    <button type="submit">Entrega de Apoyos</button>
                </form>
                
                <br>
            </td>
        </tr>
    </table>
    
    <form action="/alcaldia/controlador/DashboardControlador.php" method="get">
    <input type="hidden" name="dashboard" value="admin">
    <button type="submit">Regresar al Dashboard</button>
</form>

</body>
</html>
