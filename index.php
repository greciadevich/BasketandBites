<?php
include 'admin/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Peru'sBasketandBites</title>
    <?php include('head.php');
    ?>
</head>

<body>
    <div class="barra-informativa">
        Enviamos a toda la UE con <i class="fa-regular fa-heart"></i> desde España
    </div>
    <header class="header-container">
        <?php include('nav.php');
        ?>
    </header>
    <main>
        <?php include('menu.php');
        ?>
        <section id="lista-carrusel-contenedor">
            <div class="mi-carrusel">
                <div>
                    <img src="./pictures/1.png" alt="Imagen 1">
                </div>
                <div>
                    <img src="./pictures/2.png" alt="Imagen 2">
                </div>
                <div>
                    <img src="./pictures/3.png" alt="Imagen 3">
                </div>
                <div>
                    <img src="./pictures/4.png" alt="Imagen 4">
                </div>
                <div>
                    <img src="./pictures/5.png" alt="Imagen 5">
                </div>
                <div>
                    <img src="./pictures/6.png" alt="Imagen 6">
                </div>
                <div>
                    <img src="./pictures/7.png" alt="Imagen 7">
                </div>
                <div>
                    <img src="./pictures/8.png" alt="Imagen 8">
                </div>
            </div>
        </section>
        <!--compra-online-->
        <section class="inicio compra-online">
            <div class="compra-online-contenedor">
                <h3 class="compra-online-titulo"> Compra Online</h3>
                <p class="compra-online-texto">Recibe tu pedido en casa con la misma calidad y frescura de
                    siempre.Envíos a todos los países de la unión europea. Entre entre 24 y 48 horas.
                </p>
            </div>
            <div class="compra-online-imagen">
                <img src="./pictures/compra-online.png" alt="compra-online">

            </div>
        </section>
        <!-- tienda-->
        <section class="inicio productos-container">
            <h2>Todo los productos, los encuentras aquí</h2>
            <div class="productos index">
                <?php
                print $productosTienda = productosTienda(0, 6);
                ?>
            </div>
        </section>

        <!--folleto novedades-->
        <section class="inicio folleto">
            <a href="./novedades.php" class="boton-folleto"> Ver todas nuestras Novedades</a>
            <div class="folleto-imagen">
                <img src="./pictures/folleto.jpg" alt="folleto">
            </div>
        </section>
        <!--seccion de recetas-->
        <section class="inicio receta">
            <h2>Encuentra tu receta favorita de la semana</h2>
            <div class="row">
                <?php
                $recetas = recetasObtener();
                for ($i = 0; $i < 3; $i++) {
                ?>
                    <article class="column card" role="article">
                        <img src="imagenesproductos/<?php print $recetas[$i][7]; ?>" alt="imagen-ceviche">
                        <div class="container">
                            <h3><?php print $recetas[$i][3]; ?></h3>
                            <p><?php print $recetas[$i][6]; ?></p>
                            <a href="receta.php?rid=<?php print $recetas[$i][0]; ?>" class="boton-enlace">Ver receta</a>
                        </div>
                    </article>
                <?php
                }
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