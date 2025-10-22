<?php
// Iniciamos sesion
// cookie_lifetime = 86400 son 24 horas
session_start([
    'cookie_lifetime' => 0,
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict'
]);

include 'funciones.php';

if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'guardar') {
        // Guardamos la categoria, nueva o existente.
        usuarioGuardar($_POST);
    }
}
?>
<html>

<head>
    <title></title>
    <link rel="stylesheet" href="admin-styles.css">
</head>

<body>
    <main>
        <?php
        include('admin-header.php');

        if (isset($_GET['accion'])) {
            if ($_GET['accion'] == 'nuevo') {
                // Mostramos formulario de nuevo producto.
        ?>
                <form action="usuarios-editar.php" method="post">
                    <form action="" method="post">
                        <label for="nombre">Nombre</label><br />
                        <input type="text" placeholder="Nombre" name="nombre" required /><br />
                        <label for="apellidos">Apellidos</label><br />
                        <input type="text" placeholder="Apellidos" name="apellidos" required /><br />
                        <label for="email">Email</label><br />
                        <input type="email" placeholder="Email" name="email" required /><br />
                        <label for="telefono">Telefono</label><br />
                        <input type="text" placeholder="Telefono" name="telefono" /><br />
                        <label for="password">Password</label><br />
                        <input type="password" placeholder="Password" name="password" required /><br />
                        <label for="rol">Rol</label><br />
                        <select name="rol" required>
                            <option value="">- Seleccionar rol -</option>
                            <option value="admin">Administrador</option>
                            <option value="editor">Editor</option>
                            <option value="encargado">Encargado</option>
                            <option value="cliente">Cliente</option>
                        </select><br />
                        <input type="submit" value="Crear usuario" />
                        <a href="usuarios.php" class="boton">Cancelar</a>
                        <input type="hidden" name="destino" value="usuarios" />
                        <input type="hidden" name="accion" value="guardar" />
                        <input type="hidden" name="tipo" value="nuevo" />
                        <input type="hidden" name="uid" value="<?php isset($_GET['uid']) ? print $_GET['uid'] : print '0'; ?>" />
                    </form>
                <?php
            } else if ($_GET['accion'] == 'editar') {
                $usuario = usuarioObtenerId($_GET['uid']);
                ?>
                    <form action="usuarios-editar.php" method="post">
                        <form action="" method="post">
                            <label for="nombre">Nombre</label><br />
                            <input type="text" placeholder="Nombre" name="nombre" required value="<?php print $usuario[1] ?>" /><br />
                            <label for="apellidos">Apellidos</label><br />
                            <input type="text" placeholder="Apellidos" name="apellidos" required value="<?php print $usuario[2] ?>" /><br />
                            <label for="email">Email</label><br />
                            <input type="email" placeholder="Email" name="email" required value="<?php print $usuario[3] ?>" /><br />
                            <label for="telefono">Telefono</label><br />
                            <input type="text" placeholder="Telefono" name="telefono" value="<?php print $usuario[5] ?>" /><br />
                            <label for="rol">Rol</label><br />
                            <select name="rol" required>
                                <option value="">- Seleccionar rol -</option>
                                <option value="admin" <?php echo ($usuario[6] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                                <option value="editor" <?php echo ($usuario[6] == 'editor') ? 'selected' : ''; ?>>Editor</option>
                                <option value="encargado" <?php echo ($usuario[6] == 'encargado') ? 'selected' : ''; ?>>Encargado</option>
                                <option value="cliente" <?php echo ($usuario[6] == 'cliente') ? 'selected' : ''; ?>>Cliente</option>
                            </select><br />
                            <input type="submit" value="Editar usuario" />
                            <a href="usuarios.php" class="boton">Cancelar</a>
                            <input type="hidden" name="destino" value="usuarios" />
                            <input type="hidden" name="accion" value="guardar" />
                            <input type="hidden" name="tipo" value="editar" />
                            <input type="hidden" name="uid" value="<?php isset($_GET['uid']) ? print $_GET['uid'] : print '0'; ?>" />
                        </form>
                <?php
            }
        } else {
            print 'Error.';
        }
                ?>
    </main>
</body>

</html>