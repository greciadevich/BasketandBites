<nav>
    <a href="./index.php"><img src="./pictures/logo.png" id="logo" alt="logo"></a>
    <form action="buscar.php" method="post">
        <input type="search" name="q" placeholder="Escribe el nombre del producto o receta que buscas...">
        <input type="submit" value="Buscar">
    </form>
    <div id="nav-bottom">
    <a href="./micuenta.php" id="boton-cuenta"><img src="./pictures/user.png" alt="micuenta"><?php if (isset($_SESSION['usuarioId']) && $_SESSION['usuarioId']) print 'Hola ' . $_SESSION['usuarioNombre'] . '<br/>' ?>Mi cuenta</a>
    <div>
        <?php
        $cuentaCarrito = 0;
        if (isset($_SESSION['carrito']) && $_SESSION['carrito'] != null)
            $cuentaCarrito = count(json_decode($_SESSION['carrito'], true));
        ?>
        <a href="./cart.php" id="cart"><img src="./pictures/carrito.png" alt="carrito"><span id="cuenta-carrito"><?php print $cuentaCarrito ?></span></a>
        <!-- <span class="texto">Tu carrito: </span>
        <span class="monto">0,00</span>
        <span class="euro">€</span> -->
    </div>
    </div>
</nav>
<?php
if (isset($_SESSION['mensaje'])) {
    // Mostramos el mensaje y lo borramos para que no se repita en otras paginas.
    print '<div class="alert-box">' . $_SESSION['mensaje'] . '</div>';
    unset($_SESSION['mensaje']);
}
?>