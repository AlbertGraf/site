<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Programas Sociales</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

<header class="admin-header">
    <h2>Gestor de Programas Sociales</h2>
</header>

<main class="contenedor">
    <!-- Mostrar mensajes de éxito o error -->
    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <script>alert("<?php echo $_SESSION['mensaje_exito']; ?>");</script>
        <?php unset($_SESSION['mensaje_exito']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensaje_error'])): ?>
        <script>alert("<?php echo $_SESSION['mensaje_error']; ?>");</script>
        <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>

    <div class="acciones">
        <form action="/alcaldia/vista/admin/registrar_programa.php" method="get">
            <button type="submit" class="btn-accion">Registrar Nuevo Programa Social</button>
        </form>
    </div>

    <div class="tabla-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Término</th>
                    <th>Status</th>
                    <th>Actualizar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($programas)): ?>
                    <?php foreach ($programas as $programa): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($programa['id_programa']); ?></td>
                            <td><?php echo htmlspecialchars($programa['nombre_programa']); ?></td>
                            <td><?php echo htmlspecialchars($programa['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($programa['fecha_inicio']); ?></td>
                            <td><?php echo htmlspecialchars($programa['fecha_fin']); ?></td>
                            <td><?php echo htmlspecialchars($programa['status']); ?></td>
                            <td>
                                <form action="/alcaldia/controlador/ActualizarProgramaControlador.php" method="get">
                                    <input type="hidden" name="id_programa" value="<?php echo $programa['id_programa']; ?>">
                                    <button type="submit" class="btn-accion">Actualizar</button>
                                </form>
                            </td>
                            <td>
                                <button onclick="confirmarCuarentena(<?php echo $programa['id_programa']; ?>)" class="btn-accion">Enviar a Cuarentena</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No hay programas registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="acciones">
        <form action="/alcaldia/controlador/DashboardControlador.php" method="get">
            <input type="hidden" name="dashboard" value="admin">
            <button type="submit" class="btn-accion">Regresar al Menú principal</button>
        </form>
    </div>

    <form action="/alcaldia/controlador/ImportarProgramaControlador.php" method="post" enctype="multipart/form-data" id="formImportar" style="position: fixed; bottom: 20px; right: 20px;">
        <input type="file" name="archivo_csv" id="archivo_csv" accept=".csv" style="display: none;">
        <button type="button" class="btn-accion" onclick="document.getElementById('archivo_csv').click();">Importar Programa CSV</button>
    </form>
</main>

<script>
function confirmarCuarentena(idPrograma) {
    if (confirm("¿Estás seguro de que deseas enviar este programa social a cuarentena?")) {
        window.location.href = "/alcaldia/controlador/ExportarProgramaControlador.php?id_programa=" + idPrograma;
    }
}

document.getElementById('archivo_csv').addEventListener('change', function() {
    if (this.files.length > 0) {
        if (confirm("¿Estás seguro de importar este programa?")) {
            document.getElementById('formImportar').submit();
        }
    }
});
</script>

</body>
</html>
