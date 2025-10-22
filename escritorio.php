<?php
include 'admin/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Escritorio - Peru'sBasketandBites</title>
    <?php include('head.php'); ?>

</head>

<body id="basketandbites">
    <header class="header-container">
        <?php include('nav.php'); ?>
    </header>
    <main id="tienda">
        <?php include('menu.php'); ?>
        <div class="tienda-container inicio">
            <section class="col-tienda-izquierda">
                <div class="categorias">
                    <?php include 'menu-usuarios.php'; ?>
                </div>
            </section>

            <section class="col-tienda-derecha">
                <div class="productos">

                    <h2>Mi Escritorio</h2>
                    <p>¡Bienvenid@ a tu cuenta de Peru'sBasketandBites!</p>
                    <p>En el menú de la izquierda encontrarás toda la información referente a tu cuenta.</p>
                    <p>En el menú superior podrás acceder a las distintas sección de la tienda.</p>
                    <p>Disfruta de tu visita y no dudes en contactarnos si no encuentras algún producto.</p>

                </div>
            </section>
        </div>
    </main>

    <footer>
        <?php include('footer.php');
        ?>
    </footer>
</body>

</html>