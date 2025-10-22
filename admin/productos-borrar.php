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
if (isset($_GET['accion'])) {
    if ($_GET['accion'] == 'eliminar') {
        // Eliminamos la categoria.
        productoEliminar($_GET['pid']);
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
        ?>
        <?php
        $producto = productoObtenerId($_GET['pid']);
        ?>
        <p>¿Estás seguro de que deseas borrar el producto <?php print $producto[2] ?>?</p>
        <p><a href="productos-borrar.php?pid=<?php print $_GET['pid'] ?>&accion=eliminar" class="boton">Sí</a><a href="productos.php" class="boton">No</a></p>
    </main>
</body>

</html>