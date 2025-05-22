<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="../public/css/estilos.css">
</head>
<body>
    <header class="admin-header">
        <h2>Gestión de Usuarios</h2>
    </header>

    <main class="admin-main">
        <div class="acciones">
            <form action="/alcaldia/vista/admin/registrar_usuario.php" method="get">
                <button type="submit">Registrar Nuevo Usuario</button>
            </form>
        </div>

        <section class="tabla-usuarios">
            <h3>Lista de usuarios</h3>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID Usuario</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Contraseña</th>
                        <th>Rol</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($usuarios) && is_array($usuarios) && count($usuarios) > 0): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['clave']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                                <td>
                                    <form action="/alcaldia/controlador/ActualizarUsuarioControlador.php" method="get">
                                        <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                                        <button type="submit" class="btn-accion">Actualizar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="/alcaldia/controlador/EliminarUsuarioControlador.php" method="post">
                                        <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                                        <button type="submit" class="btn-accion eliminar">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No hay usuarios registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <div class="acciones volver">
            <form action="/alcaldia/controlador/DashboardControlador.php" method="get">
                <input type="hidden" name="dashboard" value="admin">
                <button type="submit">Regresar al Menú principal</button>
            </form>
        </div>
    </main>
</body>
</html>
