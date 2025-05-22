<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Beneficiario a Programas Sociales</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

<header class="admin-header">
    <h2>Registro de Beneficiario a Programas Sociales</h2>
</header>

<main class="contenedor">

    <!-- Mostrar mensaje de éxito -->
    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <div class="mensaje-exito">
            <?php echo $_SESSION['mensaje_exito']; ?>
        </div>
        <?php unset($_SESSION['mensaje_exito']); ?>
    <?php endif; ?>

    <!-- Mostrar mensaje de error -->
    <?php if (isset($_SESSION['mensaje_error'])): ?>
        <div class="mensaje-error">
            <?php echo $_SESSION['mensaje_error']; ?>
        </div>
        <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>

    <h3>Programas Sociales Disponibles</h3>

    <div class="tabla-responsive">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Nombre del Programa</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Días de Duración</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programas as $programa): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($programa['nombre_programa']); ?></td>
                        <td><?php echo htmlspecialchars($programa['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($programa['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($programa['fecha_fin']); ?></td>
                        <td><?php echo htmlspecialchars($programa['dias_duracion']); ?></td>
                        <td><?php echo htmlspecialchars($programa['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="botones-formulario">
        <form action="/alcaldia/controlador/RegistrarBeneficiarioProgramaSocialControlador.php" method="get">
            <button type="submit" class="btn-accion">Registrar Beneficiario a Programa</button>
        </form>

        <form action="/alcaldia/controlador/GestionarBeneficiariosControlador.php" method="get">
            <button type="submit" class="btn-accion btn-secundario">Regresar a Gestión de Beneficiarios</button>
        </form>
    </div>

</main>

</body>
</html>
