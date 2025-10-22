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
        recetaEliminar($_GET['rid']);
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
        $receta = recetaObtenerId($_GET['rid']);
        ?>
        <p>¿Estás seguro de que deseas borrar la receta "<?php print $receta[3] ?>"?</p>
        <p><a href="recetas-borrar.php?rid=<?php print $_GET['rid'] ?>&accion=eliminar" class="boton">Sí</a><a href="recetas.php" class="boton">No</a></p>
    </main>
</body>

</html>