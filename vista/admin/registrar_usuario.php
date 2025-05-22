<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../../public/css/estilos.css">
</head>
<body>
    <header class="admin-header">
        <h2>Registro de Usuario</h2>
    </header>

    <main class="form-container">
        <form method="POST" action="../../controlador/RegistrarUsuarioControlador.php" class="formulario">
            <label for="id_usuario">ID Usuario:</label>
            <input type="number" id="id_usuario" name="id_usuario" required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="clave">Contraseña:</label>
            <input type="password" id="clave" name="clave" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="administrador">Administrador</option>
                <option value="usuario">Usuario</option>
            </select>

            <button type="submit" class="btn-accion">Registrar</button>
        </form>

        <div class="acciones volver">
            <button type="button" onclick="window.history.back();">Volver a Gestionar Usuarios</button>
        </div>
    </main>
</body>
</html>
