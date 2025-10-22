<?php
include 'admin/funciones.php';
$pedido = pedidoGuardar();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Cart - Peru'sBasketandBites</title>
    <?php include('head.php'); ?>
</head>

<body>
    <header class="header-container">
        <?php include('nav.php'); ?>
    </header>
    <main>
        <?php include('menu.php'); ?>
        <div class="tienda-container inicio cart">
            <section class="col-tienda-izquierda">
                <div class="categorias">
                    <?php include 'menu-usuarios.php'; ?>
                </div>
            </section>
            <section class="col-tienda-derecha">
                <h2>Tu pedido ha sido creado</h2>
                <p>Muchas gracias por tu confianza. Tu pedido ha sido creado. Será completado y enviado a la mayor brevedad posible</p>
            </section>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>

</body>

</html>