<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proceso de Registro a Programa Social</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
</head>
<body>

<header class="admin-header">
    <h2>Proceso de Registro a Programa Social</h2>
</header>

<main class="contenedor">

    <label for="busqueda">Buscar Beneficiario:</label>
    <input type="text" id="busqueda" class="input-campo" placeholder="Escribe un nombre...">

    <div class="tabla-responsive">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Edad</th>
                    <th>Domicilio</th>
                    <th>Colonia</th>
                    <th>Delegación</th>
                    <th>Sexo</th>
                    <th>Registrar</th>
                </tr>
            </thead>
            <tbody id="tabla_resultados">
                <?php foreach ($beneficiarios as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre'] . " " . $row['apellido_paterno'] . " " . $row['apellido_materno']); ?></td>
                        <td><?php echo htmlspecialchars($row['correo']); ?></td>
                        <td><?php echo htmlspecialchars($row['edad']); ?></td>
                        <td><?php echo htmlspecialchars($row['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($row['colonia']); ?></td>
                        <td><?php echo htmlspecialchars($row['alcaldia']); ?></td>
                        <td><?php echo htmlspecialchars($row['sexo']); ?></td>
                        <td><button class="btn-accion btn-mini" onclick='abrirModal(<?php echo $row["id_beneficiario"]; ?>)'>Registrar</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="modalRegistro" class="modal">
        <div class="modal-contenido">
            <h3>Seleccionar Programa</h3>
            <select id="selectProgramas" class="input-campo"></select>
            <div class="modal-botones">
                <button onclick="registrarBeneficiario()" class="btn-accion">Registrar</button>
                <button onclick="cerrarModal()" class="btn-cancelar">Cancelar</button>
            </div>
        </div>
    </div>
    <div class="contenedor-botonera">
    <form action="/alcaldia/controlador/RegistrarBeneficiarioProgramaControlador.php" method="get" class="form-inline">
        <button type="submit" class="btn-accion btn-secundario">Regresar</button>
    </form>
</div>
</main>

<script>
let idBeneficiarioSeleccionado = null;

function abrirModal(idBeneficiario) {
    idBeneficiarioSeleccionado = idBeneficiario;

    $.ajax({
        url: "/alcaldia/controlador/ObtenerProgramasActivosControlador.php",
        method: "GET",
        success: function(data) {
            $("#selectProgramas").html(data); 
            $("#modalRegistro").show();
        }
    });
}

function cerrarModal() {
    $("#modalRegistro").hide();
}

function registrarBeneficiario() {
    let idPrograma = $("#selectProgramas").val();

    $.ajax({
        url: "/alcaldia/controlador/RegistrarEnProgramaControlador.php",
        method: "POST",
        data: {
            id_beneficiario: idBeneficiarioSeleccionado,
            id_programa: idPrograma
        },
        success: function(response) {
            alert(response);
            cerrarModal();
        }
    });
}

$(document).ready(function() {
    $("#busqueda").on("keyup", function() {
        var consulta = $(this).val();
        $.ajax({
            url: "/alcaldia/controlador/BuscarBeneficiarioProgramaControlador.php",
            method: "POST",
            data: { consulta: consulta },
            success: function(data) {
                $("#tabla_resultados").html(data); 
            }
        });
    });
});
</script>

</body>
</html>
