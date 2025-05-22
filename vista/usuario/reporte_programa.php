<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte - Programa Social</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
    <script>
        function mostrarOpciones(id_programa) {
            let formato = document.getElementById('formato_' + id_programa).value;

            if (["PDF", "CSV", "XLS"].includes(formato)) {
                fetch('/alcaldia/controlador/RegistrarReporteControlador.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id_programa=${id_programa}&formato=${formato}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let url = `/alcaldia/controlador/GenerarReportePrograma${formato}.php?id_programa=${id_programa}`;
                        window.location.href = url;
                    } else {
                        alert("Hubo un problema al registrar el reporte.");
                    }
                })
                .catch(error => {
                    alert("Error al registrar el reporte: " + error);
                });
            } else {
                alert("Formato no válido. Intente de nuevo.");
            }
        }
    </script>
</head>
<body>

    <header class="admin-header">
        <h2>Reporte de Programas Sociales</h2>
    </header>

    <main class="contenedor">

        <div class="tabla-contenedor">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Status</th>
                        <th>Generar Reporte</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($programas as $programa): ?>
                        <tr>
                            <td><?= htmlspecialchars($programa['nombre_programa']) ?></td>
                            <td><?= htmlspecialchars($programa['descripcion']) ?></td>
                            <td><?= htmlspecialchars($programa['status']) ?></td>
                            <td>
                                <select id="formato_<?= $programa['id_programa'] ?>" class="select-formato">
                                    <option value="PDF">PDF</option>
                                    <option value="CSV">CSV</option>
                                    <option value="XLS">XLS</option>
                                </select>
                                <button class="btn-accion btn-tabla" onclick="mostrarOpciones(<?= $programa['id_programa'] ?>)">Generar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
                            <div class="contenedor-botonera">
        <form action="/alcaldia/controlador/GenerarReporteControlador.php" method="get" class="form-inline" style="margin-top: 30px;">
            <button type="submit" class="btn-accion btn-secundario">Regresar</button>
        </form>
                            </div>
    </main>

</body>
</html>
