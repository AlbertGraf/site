<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Beneficiarios</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

<header class="admin-header">
    <h2>Gestión de Beneficiarios</h2>
</header>

<main class="contenedor">

    <section class="contenedor-botonera">
        <h3 class="centrado">¿Qué deseas hacer?</h3>

        <form action="/alcaldia/vista/admin/registrar_beneficiario.php" method="get">
            <button type="submit" class="btn-accion">Registrar Beneficiario</button>
        </form>

        <form action="/alcaldia/controlador/GestionarBeneficiariosListaControlador.php" method="get">
            <button type="submit" class="btn-accion">Consultar, Modificar o Eliminar Beneficiario</button>
        </form>

        <form action="/alcaldia/controlador/RegistrarBeneficiarioProgramaControlador.php" method="get">
            <button type="submit" class="btn-accion">Registrar Beneficiario a Programa Social</button>
        </form>

        <form action="/alcaldia/controlador/EntregaApoyoControlador.php" method="get">
            <button type="submit" class="btn-accion">Entrega de Apoyos</button>
        </form>
    </section>

    <br>

    <div class="contenedor-botonera">
    <form action="/alcaldia/controlador/DashboardControlador.php" method="get">
        <input type="hidden" name="dashboard" value="admin">
        <button type="submit" class="btn-accion">Regresar al Menú Principal</button>
    </form>
</div>

</main>

</body>
</html>
