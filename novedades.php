<?php
include 'admin/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Novedades - Peru'sBasketandBites</title>
    <?php include('head.php');
    ?>
</head>

<body>
    <header class="header-container">
        <?php include('nav.php');
        ?>
    </header>
    <main>
        <?php include('menu.php');
        ?>
        <div class=" folleto-novedades">
            <img src="./pictures/foto-novedades.jpg" alt="folleto-novedades">
        </div>

        <section class="inicio productos-container">
            <h2>Nuestros nuevos productos</h2>
            <div class="productos index">
                <?php
                print $productosTienda = productosTienda(0, 12);
                ?>
            </div>
        </section>
        <!--seccion nuestras marcas-->
        <section class="inicio marcas">
            <h2>Tenemos para tí, las mejores marcas del mercado</h2>
            <div class="marcas-imagen">
                <img src="./pictures/marca1.jpg" alt="marca1">
                <img src="./pictures/marca2.png" alt="marca2">
                <img src="./pictures/marca3.png" alt="marca3">
                <img src="./pictures/marca4.png" alt="marca4">
                <img src="./pictures/marca5.png" alt="marca5">
                <img src="./pictures/marca6.jpg" alt="marca6">
            </div>
        </section>

    </main>

    <footer>
        <?php include('footer.php');
        ?>
    </footer>

</body>

</html>