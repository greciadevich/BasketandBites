<?php
// ESTE CODIGO DEBE IR SIEMPRE AL PRINCIPIO DEL TODO
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
    if ($_GET['accion'] == 'borrar') {
        pedidoEliminar($_GET['pid']);
    } else if ($_GET['accion'] == 'enviar') {
        pedidoEnviar($_GET['pid'], $_GET['uid']);
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

        // Mostramos listado de productos.
        print pedidosTabla();

        ?>
    </main>
</body>

</html>