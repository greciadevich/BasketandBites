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
        usuarioEliminar($_GET['uid']);
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
        $usuario = usuarioObtenerId($_GET['uid']);
        ?>
        <p>¿Estás seguro de que deseas borrar el usuario <?php print $usuario[1].' '.$usuario[2] ?>?</p>
        <p><a class="boton" href="usuarios-borrar.php?uid=<?php print $_GET['uid'] ?>&accion=eliminar">Sí</a> - <a href="usuarios.php" class="boton">No</a></p>
    </main>
</body>

</html>