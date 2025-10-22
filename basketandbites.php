<?php
include 'admin/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>FAQ - Peru'sBasketandBites</title>
    <?php include('head.php'); ?>
</head>

<body id="basketandbites">
    <header class="header-container">
        <?php include('nav.php');
        ?>
    </header>
    <main>
        <?php include('menu.php');
        ?>
        <div class="inicio folleto-inspirate">
            <img src="./pictures/inspirate.png" alt="inspirate">
        </div>
        <section class="inicio">
            <div class="seccion" id="primera-seccion">
                <img src="./pictures/tienda.jpg" style="width: 500px; margin-right: 20px;">
                <div>
                    <h2>Nuestra tienda</h2>
                    <p>En nuestra acogedora tienda, que aunque pequeña, está repleta de variedad, podrás explorar no solo todos los productos disponibles en nuestro sitio web sino también una extensa selección de artículos que no están en línea, incluyendo una amplia variedad de productos frescos y congelados. Contamos con una surtida oferta de congelados como maiz, humitas, yuca, olluco, ají amarillo, ají limo, etc. Nos encantaría tener la oportunidad de conocerte personalmente. Si te encuentras en Reus o sus alrededores, o simplemente estás visitando o disfrutando de unas vacaciones por la zona, ven y disfruta de una experiencia de compra única con nosotros.</p>
                </div>
            </div>


            <div class="secciones-inferiores">
                <div class="seccion" id="segunda-seccion">
                    <h2>Nuestra Tienda en Fotos</h2>
                    <div class="sidebar-2">
                        <img src="./pictures/3.png" alt="imagen1">
                        <img src="./pictures/5.png" alt="imagen2">
                        <img src="./pictures/9.jpg" alt="imagen3">
                    </div>
                </div>
                <div class="seccion" id="tercera-seccion">
                    <h2>Localizacion de la Tienda</h2>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12015.035510493257!2d1.1047632!3d41.1616125!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a151044692d8cd%3A0xf31e7c73f05916a4!2sLOLA!5e0!3m2!1sen!2ses!4v1714515089226!5m2!1sen!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                </div>

            </div>
        </section>
    </main>

    <footer>
        <?php include('footer.php');
        ?>
    </footer>

</body>

</html>