<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Programa Social</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

<header class="admin-header">
    <h2>Actualizar Programa Social</h2>
</header>

<main class="contenedor">

    <?php if ($error): ?>
        <div class="mensaje-error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($programa): ?>
        <form method="post" action="/alcaldia/controlador/ActualizarProgramaControlador.php" class="formulario">
            <input type="hidden" name="id_programa" value="<?php echo htmlspecialchars($programa['id_programa'] ?? ''); ?>">

            <label for="nombre_programa">Nombre del Programa:</label>
            <input type="text" name="nombre_programa" id="nombre_programa"
                   value="<?php echo htmlspecialchars($programa['nombre_programa'] ?? ''); ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="4" required><?php echo htmlspecialchars($programa['descripcion'] ?? ''); ?></textarea>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio"
                   value="<?php echo htmlspecialchars($programa['fecha_inicio'] ?? ''); ?>" required>

            <label for="fecha_fin">Fecha de Término:</label>
            <input type="date" name="fecha_fin" id="fecha_fin"
                   value="<?php echo htmlspecialchars($programa['fecha_fin'] ?? ''); ?>" required>

            <button type="submit" class="btn-accion">Actualizar Programa</button>
        </form>
    <?php else: ?>
        <div class="mensaje-error">
            Por favor, seleccione un programa desde <a href="gestionar_programas.php">Gestionar Programas</a>
        </div>
    <?php endif; ?>

    <br>

    <form action="/alcaldia/controlador/GestionarProgramasControlador.php" method="get">
        <button type="submit" class="btn-accion">Regresar</button>
    </form>

</main>

</body>
</html>
