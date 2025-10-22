<?php
include 'admin/funciones.php';
$_SESSION['total'] = $_POST['total'];
$_SESSION['did'] = $_POST['did'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Cart - Peru'sBasketandBites</title>
    <?php include('head.php'); ?>
    <link rel="stylesheet" href="checkout.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script src="checkout.js" defer></script>

</head>

<body>
    <header class="header-container">
        <?php include('nav.php'); ?>
    </header>
    <main>
        <?php include('menu.php'); ?>
        <div class="tienda-container inicio pago cart">
            <h2>Tu carrito de la compra</h2>
            <p>Se va a proceder al pago de tu pedido.</p>
            <p>La cantidad total es de <?php print $_POST['total'] ?>&euro;.</p>
            <p>Esto es un entorno de pruebas y se pueden utilizar los siguientes números de tarjeta de crédito utilizando cualquier fecha de vencimiento futura y código CVC:
            <ul>
                <li>4242 4242 4242 4242: el pago se realiza correctamente.</li>
                <li>4000 0025 0000 3155: la tarjeta requiere de autenticación extra.</li>
                <li>4000 0000 0000 9995: tarjeta rechazada.</li>
            </ul>
            </p>
            <!-- Display a payment form -->
            <form id="payment-form">
                <div id="payment-element">
                    <!--Stripe.js injects the Payment Element-->
                </div>
                <button id="submit" class="boton-rojo">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Completar pago</span>
                </button>
                <div id="payment-message" class="hidden"></div>
            </form>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>

</body>

</html>