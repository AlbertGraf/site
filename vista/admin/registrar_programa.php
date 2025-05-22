<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Programa Social</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>

<header class="admin-header">
    <h2>Registro de Programa Social</h2>
</header>

<main class="contenedor">
    <form method="post" action="/alcaldia/controlador/RegistrarProgramaControlador.php" class="formulario">
        <label for="id_programa">ID Programa:</label>
        <input type="number" name="id_programa" id="id_programa" required>

        <label for="nombre_programa">Nombre del Programa:</label>
        <input type="text" name="nombre_programa" id="nombre_programa" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="4" required></textarea>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" required>

        <label for="fecha_fin">Fecha de Término:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" required>

        <button type="submit" class="btn-accion">Guardar Registro</button>
    </form>

    <br>

    <form action="/alcaldia/controlador/GestionarProgramasControlador.php" method="get">
        <button type="submit" class="btn-accion">Regresar a Gestionar Programas</button>
    </form>
</main>

</body>
</html>
