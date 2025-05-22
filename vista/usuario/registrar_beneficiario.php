<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Beneficiario</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

<header class="admin-header">
    <h2>Registro de Beneficiario</h2>
</header>

<main class="contenedor-formulario">
    <form action="/alcaldia/controlador/RegistrarBeneficiarioControlador.php" method="post" enctype="multipart/form-data">

        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Apellido Paterno:</label>
        <input type="text" name="apellido_paterno" required>

        <label>Apellido Materno:</label>
        <input type="text" name="apellido_materno" required>

        <label>Edad:</label>
        <input type="number" name="edad" required>

        <label>Género:</label>
        <select name="sexo" required>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
            <option value="Otro">Otro</option>
        </select>

        <label>Dirección:</label>
        <input type="text" name="direccion" required>

        <label>Código Postal:</label>
        <input type="text" id="codigo_postal" name="codigo_postal" required>

        <label>Colonia:</label>
        <select id="colonia" name="colonia" required>
            <option value="">Selecciona una colonia</option>
        </select>

        <label>Teléfono:</label>
        <input type="text" name="telefono">

        <label>Correo Electrónico:</label>
        <input type="email" name="correo">

        <label>Subir CURP (PDF):</label>
        <input type="file" name="curp_pdf" accept="application/pdf" required>

        <label>Subir Acta de Nacimiento (PDF):</label>
        <input type="file" name="acta_nacimiento_pdf" accept="application/pdf" required>

        <label>Subir Comprobante de Domicilio (PDF):</label>
        <input type="file" name="comprobante_domicilio_pdf" accept="application/pdf" required>

        <button type="submit" class="btn-accion">Registrar Beneficiario</button>
    </form>

    <br>

    <form action="/alcaldia/controlador/GestionarBeneficiariosControlador.php" method="get">
        <button type="submit" class="btn-accion">Regresar</button>
    </form>
</main>

<script>
    const coloniasPorCP = {
        "13280": ["Agrícola Metropolitana"],
        "13419": ["Ampliación José López Portillo"],
        "13545": ["Ampliación La Conchita"],
        "13219": ["Ampliación Los Olivos", "Las Arboledas"],
        "13120": ["Ampliación Santa Catarina", "Santiago"],
        "13430": ["Ampliación Selene"],
        "13315": ["Ampliación Zapotitla"],
        "13270": ["Del Mar"],
        "13540": ["El Rosario", "Tierra Blanca"],
        "13460": ["El Triángulo"],
        "13520": ["Francisco Villa"],
        "13230": ["Granjas Cabrera"],
        "13450": ["Guadalupe Tlaltenco", "Ojo de Agua"],
        "13530": ["Jaime Torres Bodet", "La Asunción"],
        "13550": ["Jardines del Llano", "Potrero del Llano"],
        "13000": ["Barrio La Asunción", "Santiago Centro", "Santiago Norte"],
        "13150": ["Barrio La Concepción"],
        "13509": ["La Concepción"],
        "13360": ["La Conchita Zapotitlán", "Santiago Sur"],
        "13273": ["La Draga"],
        "13319": ["La Estación"],
        "13060": ["Barrio La Guadalupe", "Santa Ana"],
        "13100": ["La Guadalupe"],
        "13050": ["La Habana"],
        "13510": ["La Lupita"],
        "13070": ["La Magdalena", "Barrio San Miguel"],
        "13220": ["La Nopalera"],
        "13508": ["La Soledad", "Barrio San Agustín"],
        "13250": ["La Turba"],
        "13410": ["López Portillo"],
        "13210": ["Los Olivos"],
        "13080": ["Barrio Los Reyes"],
        "13610": ["Los Reyes"],
        "13200": ["Miguel Hidalgo"],
        "13549": ["Peña Alta"],
        "13090": ["Quiahuatla"],
        "13630": ["San Agustín"],
        "13099": ["San Andrés"],
        "13600": ["San Bartolomé"],
        "13400": ["San Francisco Tlaltenco"],
        "13094": ["San Isidro"],
        "13020": ["San José"],
        "13030": ["San Juan"],
        "13640": ["San Mateo", "San Miguel"],
        "13180": ["San Miguel"],
        "13700": ["San Nicolás Tetelco", "Tepantitlamilco"],
        "13093": ["San Sebastián"],
        "13300": ["Santa Ana Centro", "Santa Ana Norte", "Santa Ana Poniente", "Santa Ana Sur"],
        "13010": ["Santa Cecilia"],
        "13625": ["Santa Cruz"],
        "13420": ["Selene"],
        "13278": ["Villa Centroamericana"],
        "13440": ["Zacatenco"],
        "13310": ["Zapotitla"]
    };

    document.addEventListener("DOMContentLoaded", function () {
        const inputCP = document.getElementById("codigo_postal");
        const selectColonia = document.getElementById("colonia");

        function llenarColonias(cpSeleccionado) {
            selectColonia.innerHTML = "<option value=''>Selecciona una colonia</option>";
            if (coloniasPorCP[cpSeleccionado]) {
                coloniasPorCP[cpSeleccionado].forEach(colonia => {
                    const option = document.createElement("option");
                    option.value = colonia;
                    option.textContent = colonia;
                    selectColonia.appendChild(option);
                });
                selectColonia.disabled = false;
            } else {
                selectColonia.disabled = true;
            }
        }

        inputCP.addEventListener("input", function () {
            const cp = inputCP.value.trim();
            if (coloniasPorCP[cp]) {
                llenarColonias(cp);
                selectColonia.selectedIndex = 1;
            }
        });

        selectColonia.addEventListener("change", function () {
            const coloniaSeleccionada = selectColonia.value;
            for (const cp in coloniasPorCP) {
                if (coloniasPorCP[cp].includes(coloniaSeleccionada)) {
                    inputCP.value = cp;
                    break;
                }
            }
        });

        if (inputCP.value.trim() !== "") {
            llenarColonias(inputCP.value.trim());
        }
    });
</script>

</body>
</html>
