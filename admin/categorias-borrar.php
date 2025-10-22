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
        categoriaEliminar($_GET['cid']);
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
        $categoria = categoriasObtenerId($_GET['cid']);
        ?>
        <p>¿Estás seguro de que deseas borrar la categoría <?php print $categoria[1] ?>?</p>
        <p><a href="categorias-borrar.php?cid=<?php print $_GET['cid'] ?>&accion=eliminar" class="boton">Sí</a><a href="categorias.php" class="boton">No</a></p>
    </main>
</body>

</html>