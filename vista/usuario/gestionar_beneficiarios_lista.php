<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Beneficiarios</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
</head>
<body>

<header class="admin-header">
    <h2>Lista de Beneficiarios</h2>
</header>

<main class="contenedor">

    <div class="campo-formulario">
        <label for="busqueda">Buscar Beneficiario:</label>
        <input type="text" id="busqueda" placeholder="Escribe un nombre...">
    </div>

    <br>

    <div class="tabla-contenedor">
        <table class="tabla-estilizada">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Colonia</th>
                    <th>Edad</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>CURP PDF</th>
                    <th>Acta Nacimiento</th>
                    <th>Comprobante Domicilio</th>
                    <th>Actualizar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody id="tabla_resultados">
                <?php foreach ($beneficiarios as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nombre'] . " " . $row['apellido_paterno'] . " " . $row['apellido_materno']); ?></td>
                    <td><?php echo htmlspecialchars($row['direccion']); ?></td>
                    <td><?php echo htmlspecialchars($row['colonia']); ?></td>
                    <td><?php echo htmlspecialchars($row['edad']); ?></td>
                    <td><?php echo htmlspecialchars($row['correo']); ?></td>
                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                    <td><a href="/alcaldia/uploads/<?php echo basename($row['curp_pdf']); ?>" target="_blank">Ver</a></td>
                    <td><a href="/alcaldia/uploads/<?php echo basename($row['acta_nacimiento_pdf']); ?>" target="_blank">Ver</a></td>
                    <td><a href="/alcaldia/uploads/<?php echo basename($row['comprobante_domicilio_pdf']); ?>" target="_blank">Ver</a></td>
                    <td>
                        <form action="/alcaldia/controlador/ActualizarBeneficiarioControlador.php" method="get">
                            <input type="hidden" name="id_beneficiario" value="<?php echo $row['id_beneficiario']; ?>">
                            <button type="submit" class="btn-tabla">Actualizar</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn-tabla btn-rojo" onclick="confirmarEliminacion(<?php echo $row['id_beneficiario']; ?>, '<?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno']); ?>')">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <br>
    <div class="contenedor-botonera">
    <form action="/alcaldia/controlador/GestionarBeneficiariosControlador.php" method="get">
        <button type="submit" class="btn-accion">Regresar</button>
    </form>
    </div>
</main>

<script>
$(document).ready(function() {
    $("#busqueda").on("keyup", function() {
        var consulta = $(this).val();
        $.ajax({
            url: "/alcaldia/controlador/BuscarBeneficiarioControlador.php",
            method: "POST",
            data: { consulta: consulta },
            success: function(data) {
                $("#tabla_resultados").html(data);
            },
            error: function(xhr, status, error) {
                console.log("Error en AJAX:", status, error);
            }
        });
    });
});
</script>

<script>
function confirmarEliminacion(idBeneficiario, nombre) {
    if (confirm("¿Estás seguro de que deseas eliminar al beneficiario " + nombre + "?")) {
        window.location.href = "/alcaldia/controlador/EliminarBeneficiarioControlador.php?id_beneficiario=" + idBeneficiario;
    }
}
</script>

</body>
</html>
