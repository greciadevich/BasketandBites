<?php
include 'admin/funciones.php';
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
            <h2>Tu carrito de la compra</h2>
            <?php
            if (isset($_SESSION['carrito']) && $_SESSION['carrito'] != json_encode([])) {
                $carritoCompra = json_decode($_SESSION['carrito'], true);
                print carritoTablaPago($carritoCompra, $_POST['direccionseleccionada']);
            } else {
                print 'Tu carrito está vacío.';
            }
            ?>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>

</body>

</html>