<?php
include 'admin/funciones.php';
if (!isset($_SESSION['usuarioId'])) {
    mensajeAlerta('Debes registrarte para continuar con la compra.');
    header('Location: micuenta.php');
    exit();
}
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
            <h2>Dirección de envío.</h2>
            <?php
            if (isset($_SESSION['carrito']) && $_SESSION['carrito'] != json_encode([])) {
                print '<p>Elige la dirección a la que realizar el envío.</p>';
                print direccionesTablaCarrito();
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