<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entrega de Apoyos</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
</head>
<body>

<header class="admin-header">
    <h2>Entrega de Apoyos</h2>
</header>

<main class="contenedor">

    <div class="form-group">
        <label for="filtroPrograma">Filtrar por Programa Social:</label>
        <select id="filtroPrograma" class="input-campo">
            <option value="">Todos</option>
            <?php foreach ($programas as $programa): ?>
                <option value="<?php echo htmlspecialchars($programa['id_programa']); ?>">
                    <?php echo htmlspecialchars($programa['nombre_programa']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="busqueda">Buscar Beneficiario:</label>
        <input type="text" id="busqueda" class="input-campo" placeholder="Escribe un nombre...">
    </div>

    <div class="tabla-responsive">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Beneficiario</th>
                    <th>Correo</th>
                    <th>Domicilio</th>
                    <th>Colonia</th>
                    <th>Alcaldía</th>
                    <th>Programa Social</th>
                    <th>Fecha de Asignación</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="tabla_entregas">
                <!-- Datos se llenarán con AJAX -->
            </tbody>
        </table>
    </div>
                <div class="contenedor-botonera">
    <form action="/alcaldia/controlador/GestionarBeneficiariosControlador.php" method="get" class="form-inline">
        <button type="submit" class="btn-accion btn-secundario">Regresar</button>
    </form>
                </div>
</main>

<script>
    function cargarEntregas() {
        var idPrograma = $("#filtroPrograma").val();
        var consulta = $("#busqueda").val();

        $.ajax({
            url: "/alcaldia/controlador/FiltrarEntregasControlador.php",
            method: "POST",
            data: { id_programa: idPrograma, consulta: consulta },
            success: function(data) {
                $("#tabla_entregas").html(data);
            }
        });
    }

    $(document).ready(function() {
        cargarEntregas();

        $("#filtroPrograma").on("change", function() {
            cargarEntregas();
        });

        $("#busqueda").on("keyup", function() {
            cargarEntregas();
        });
    });

    function marcarEntregado(idBeneficiario, idPrograma) {
        $.ajax({
            url: "/alcaldia/controlador/ActualizarEntregaControlador.php",
            method: "POST",
            data: {
                id_beneficiario: idBeneficiario,
                id_programa: idPrograma
            },
            success: function(response) {
                if (response === "success") {
                    $("#status_" + idBeneficiario + "_" + idPrograma).text("Entregado");
                    $("#fila_" + idBeneficiario + "_" + idPrograma).fadeOut(1000);
                } else {
                    alert("Error al actualizar el estado.");
                }
            }
        });
    }
</script>

</body>
</html>
