<?php
// Comprobamos si existe usuarioRol en la sesion. Si existe, el usuario ya esta conectado.
// Si no lo esta, mostramos el formulario.
if (isset($_SESSION['usuarioRol'])) {
    // print 'rol ' . $_SESSION['usuarioRol'];
    if ($_SESSION['usuarioRol'] == 'admin') {
?>
        <div>Bienvenido <?php print $_SESSION['usuarioNombre'] . ' ' . $_SESSION['usuarioApellidos'] ?></div>
        <header>
            <ul class="menu">
            <li><a href="usuarios.php">Usuarios</a>
                    <ul>
                        <li><a href="usuarios-editar.php?accion=nuevo">Nuevo Usuario</a></li>
                    </ul>
                </li>
                <li><a href="categorias.php">Categorías</a>
                    <ul>
                        <li><a href="categorias-editar.php?accion=nueva">Nueva Categoría</a></li>
                    </ul>
                </li>
                <li><a href="productos.php">Productos</a>
                    <ul>
                        <li><a href="productos-editar.php?accion=nuevo">Nuevo Producto</a>
                    </ul>
                </li>
                <li><a href="recetas.php">Recetas</a>
                    <ul>
                        <li><a href="recetas-editar.php?accion=nueva">Nueva Receta</a></li>
                    </ul>
                </li>
                <li><a href="pedidos.php">Pedidos</a></li>
                <li><a href="logout.php">Desconectar</a></li>
            </ul>
        </header>
<?php
    } else {
        // Usuario no autorizado. Borramos sesion por seguridad.
        header('Location: logout.php');
        exit();
    }
}
if (isset($_SESSION['mensaje'])) {
    // Mostramos el mensaje y lo borramos para que no se repita en otras paginas.
    print '<div class="alert-box">' . $_SESSION['mensaje'] . '</div>';
    unset($_SESSION['mensaje']);
}
?>