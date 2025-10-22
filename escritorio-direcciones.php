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
                    <h2>Direcciones</h2>
                    <?php print direccionesTabla($_SESSION['usuarioId']); ?>
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