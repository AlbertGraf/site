<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Usuario</title>
    <link rel="stylesheet" href="/alcaldia/public/css/estilos.css">
</head>
<body>
    <header class="admin-header">
        <h2>Actualizar Usuario</h2>
    </header>

    <main class="form-container">
        <?php if ($error): ?>
            <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if ($usuario): ?>
            <form method="POST" action="/alcaldia/controlador/ActualizarUsuarioControlador.php" class="formulario">
                <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario'] ?? ''); ?>">

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>" required>

                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo'] ?? ''); ?>" required>

                <label for="clave">Contraseña:</label>
                <input type="text" id="clave" name="clave" value="<?php echo htmlspecialchars($usuario['clave'] ?? ''); ?>" required>

                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <option value="administrador" <?php if (($usuario['rol'] ?? '') === 'administrador') echo 'selected'; ?>>Administrador</option>
                    <option value="usuario" <?php if (($usuario['rol'] ?? '') === 'usuario') echo 'selected'; ?>>Usuario</option>
                </select>

                <button type="submit" name="actualizar" class="btn-accion">Actualizar</button>
            </form>
        <?php else: ?>
            <p>Por favor, seleccione un usuario desde <a href="gestionar_usuarios.php">Gestionar Usuarios</a></p>
        <?php endif; ?>

        <div class="acciones volver">
            <button type="button" onclick="window.history.back();">Regresar</button>
        </div>
    </main>
</body>
</html>
