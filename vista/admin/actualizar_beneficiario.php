<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Beneficiario</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

<header class="admin-header">
    <h2>Actualizar Beneficiario</h2>
</header>

<main class="contenedor">
    <form class="formulario" action="/alcaldia/controlador/ActualizarBeneficiarioControlador.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_beneficiario" value="<?php echo htmlspecialchars($beneficiario['id_beneficiario']); ?>">

        <div class="campo-formulario">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($beneficiario['nombre']); ?>" required>
        </div>

        <div class="campo-formulario">
            <label>Apellido Paterno:</label>
            <input type="text" name="apellido_paterno" value="<?php echo htmlspecialchars($beneficiario['apellido_paterno']); ?>" required>
        </div>

        <div class="campo-formulario">
            <label>Apellido Materno:</label>
            <input type="text" name="apellido_materno" value="<?php echo htmlspecialchars($beneficiario['apellido_materno']); ?>" required>
        </div>

        <div class="campo-formulario">
            <label>Edad:</label>
            <input type="number" name="edad" value="<?php echo htmlspecialchars($beneficiario['edad']); ?>" required>
        </div>

        <div class="campo-formulario">
            <label>Sexo:</label>
            <select name="sexo" required>
                <option value="M" <?php if ($beneficiario['sexo'] == 'M') echo 'selected'; ?>>Masculino</option>
                <option value="F" <?php if ($beneficiario['sexo'] == 'F') echo 'selected'; ?>>Femenino</option>
                <option value="Otro" <?php if ($beneficiario['sexo'] == 'Otro') echo 'selected'; ?>>Otro</option>
            </select>
        </div>

        <div class="campo-formulario">
            <label>Dirección:</label>
            <input type="text" name="direccion" value="<?php echo htmlspecialchars($beneficiario['direccion']); ?>" required>
        </div>

        <div class="campo-formulario">
            <label>Colonia:</label>
            <select name="colonia" required>
                <?php
                $colonias_por_cp = [
                    "13280" => ["Agrícola Metropolitana"],
                    "13419" => ["Ampliación José López Portillo"],
                    "13545" => ["Ampliación La Conchita"],
                    "13219" => ["Ampliación Los Olivos", "Las Arboledas"],
                    "13120" => ["Ampliación Santa Catarina", "Santiago"],
                    "13430" => ["Ampliación Selene"],
                    "13315" => ["Ampliación Zapotitla"],
                    "13270" => ["Del Mar"],
                    "13540" => ["El Rosario", "Tierra Blanca"],
                    "13460" => ["El Triángulo"],
                    "13520" => ["Francisco Villa"],
                    "13230" => ["Granjas Cabrera"],
                    "13450" => ["Guadalupe Tlaltenco", "Ojo de Agua"],
                    "13530" => ["Jaime Torres Bodet", "La Asunción"],
                    "13550" => ["Jardines del Llano", "Potrero del Llano"],
                    "13000" => ["Barrio La Asunción", "Santiago Centro", "Santiago Norte"],
                    "13150" => ["Barrio La Concepción"],
                    "13509" => ["La Concepción"],
                    "13360" => ["La Conchita Zapotitlán", "Santiago Sur"],
                    "13273" => ["La Draga"],
                    "13319" => ["La Estación"],
                    "13060" => ["Barrio La Guadalupe", "Santa Ana"],
                    "13100" => ["La Guadalupe"],
                    "13050" => ["La Habana"],
                    "13510" => ["La Lupita"],
                    "13070" => ["La Magdalena", "Barrio San Miguel"],
                    "13220" => ["La Nopalera"],
                    "13508" => ["La Soledad", "Barrio San Agustín"],
                    "13250" => ["La Turba"],
                    "13410" => ["López Portillo"],
                    "13210" => ["Los Olivos"],
                    "13080" => ["Barrio Los Reyes"],
                    "13610" => ["Los Reyes"],
                    "13200" => ["Miguel Hidalgo"],
                    "13549" => ["Peña Alta"],
                    "13090" => ["Quiahuatla"],
                    "13630" => ["San Agustín"],
                    "13099" => ["San Andrés"],
                    "13600" => ["San Bartolomé"],
                    "13400" => ["San Francisco Tlaltenco"],
                    "13094" => ["San Isidro"],
                    "13020" => ["San José"],
                    "13030" => ["San Juan"],
                    "13640" => ["San Mateo", "San Miguel"],
                    "13180" => ["San Miguel"],
                    "13700" => ["San Nicolás Tetelco", "Tepantitlamilco"],
                    "13093" => ["San Sebastián"],
                    "13300" => ["Santa Ana Centro", "Santa Ana Norte", "Santa Ana Poniente", "Santa Ana Sur"],
                    "13010" => ["Santa Cecilia"],
                    "13625" => ["Santa Cruz"],
                    "13420" => ["Selene"],
                    "13278" => ["Villa Centroamericana"],
                    "13440" => ["Zacatenco"],
                    "13310" => ["Zapotitla"]
                ];

                $opciones = [];
                foreach ($colonias_por_cp as $cp => $lista) {
                    foreach ($lista as $colonia) {
                        $etiqueta = "$colonia (CP $cp)";
                        $opciones[$colonia] = $etiqueta;
                    }
                }

                
                asort($opciones);

                foreach ($opciones as $colonia => $etiqueta) {
                    $selected = ($beneficiario['colonia'] == $colonia) ? 'selected' : '';
                    echo "<option value=\"$colonia\" $selected>$etiqueta</option>";
                }
                ?>
            </select>
        </div>

        <div class="campo-formulario">
            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo htmlspecialchars($beneficiario['telefono']); ?>">
        </div>

        <div class="campo-formulario">
            <label>Correo:</label>
            <input type="email" name="correo" value="<?php echo htmlspecialchars($beneficiario['correo']); ?>">
        </div>

        <div class="campo-formulario">
            <label>CURP (PDF):</label>
            <input type="file" name="curp_pdf">
            <?php if (!empty($beneficiario['curp_pdf'])): ?>
                <a href="/alcaldia/uploads/<?php echo basename($beneficiario['curp_pdf']); ?>" target="_blank">Ver CURP</a>
            <?php endif; ?>
        </div>

        <div class="campo-formulario">
            <label>Acta de Nacimiento (PDF):</label>
            <input type="file" name="acta_nacimiento_pdf">
            <?php if (!empty($beneficiario['acta_nacimiento_pdf'])): ?>
                <a href="/alcaldia/uploads/<?php echo basename($beneficiario['acta_nacimiento_pdf']); ?>" target="_blank">Ver Acta</a>
            <?php endif; ?>
        </div>

        <div class="campo-formulario">
            <label>Comprobante de Domicilio (PDF):</label>
            <input type="file" name="comprobante_domicilio_pdf">
            <?php if (!empty($beneficiario['comprobante_domicilio_pdf'])): ?>
                <a href="/alcaldia/uploads/<?php echo basename($beneficiario['comprobante_domicilio_pdf']); ?>" target="_blank">Ver Comprobante</a>
            <?php endif; ?>
        </div>

        <div class="contenedor-botonera">
            <button type="submit" class="btn-accion">Actualizar Beneficiario</button>
            <a href="/alcaldia/controlador/GestionarBeneficiariosListaControlador.php" class="btn-accion btn-secundario">Regresar</a>
        </div>
    </form>
</main>

</body>
</html>
