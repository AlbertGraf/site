<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrador</title>
    <link rel="stylesheet" href="../public/css/estilos.css">
</head>
<body>
    <header class="admin-header">
        <h2>Bienvenido, <?php echo $nombre_usuario; ?> <span class="rol">/ Administrador</span></h2>
    </header>

    <main class="admin-main">
        <section class="bienvenida">
            <h1>Plataforma de registro unificado para la gestión de beneficiarios de acciones sociales en la Alcaldía Tláhuac</h1>
            <h3>¿Qué deseas hacer hoy?</h3>
        </section>

        <section class="acciones">
            <form action="../controlador/GestionarUsuariosControlador.php" method="get">
                <button type="submit">Gestionar Usuarios</button>
            </form>
            <form action="../controlador/GestionarProgramasControlador.php" method="get">
                <button type="submit">Gestionar Programas Sociales</button>
            </form>
            <form action="/alcaldia/controlador/GestionarBeneficiariosControlador.php" method="get">
                <button type="submit">Gestión de Beneficiarios</button>
            </form>
            <form action="/alcaldia/controlador/ReportesControlador.php" method="get">
                <button type="submit">Reportes</button>
            </form>
            <form action="/alcaldia/controlador/RespaldoControlador.php" method="get">
                <button type="submit">Respaldo</button>
            </form>
        </section>

        <hr>

        <div class="cerrar-sesion">
    <form action="../controlador/cerrar_sesion.php" method="post">
        <button type="submit" class="cerrar-btn">Cerrar Sesión</button>
    </form>
</div>
    </main>
</body>
</html>
