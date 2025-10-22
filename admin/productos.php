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
        print productosTabla();

        ?>
    </main>
</body>

</html>