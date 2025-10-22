<?php
include 'admin/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Recetas - Peru'sBasketandBites</title>
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
        <div class=" folleto-recetas">
            <img src="./pictures/foto-recetas.jpg" alt="folleto-recetas">
        </div>
        <h2>Últimas entradas</h2>
        <div class="recipe-container">
            <section class="row-recetas">
                <?php
                print recetasSemana();
                ?>
            </section>

            <aside class="sidebar">
                <div class="sidebar-1">
                    <h3>Buscador</h3>
                    <form action="buscar_preguntar.php" method="post">
                        <input type="search" name="q" placeholder="Escribe la receta que buscas...">
                        <input type="submit" value="Buscar">
                    </form>
                </div>
                <hr class="linea-separadora">
                <h3>Nuestras novedades</h3>
                <div class="sidebar-2">
                    <img src="./pictures/imagen1.png" alt="imagen1">
                    <img src="./pictures/imagen2.png" alt="imagen2">
                    <img src="./pictures/imagen3.png" alt="imagen3">
                </div>
                <hr class="linea-separadora">
                <div class="sidebar-3">
                    <h3>Visita nuestra tienda</h3>
                    <p>Tienda física
                        Plaza Font Nova 2, local B - Reus
                        623 10 18 00 </p>

                    <p> Horario
                        Lunes—Viernes: 9:30 - 14:00hrs. / 16:30 - 21:00hrs.
                        Sábados: 10:00 - 14:00hrs. / 17:30 - 21:00hrs. </p>

                    <a href="./acercadenosotros.php" class="boton-enlace">Acerca de nosotros </a>
                </div>
                <hr class="linea-separadora">
                <div class="sidebar-4">
                    <h3>¡Síguenos en nuestras redes sociales!</h3>
                    <i class="fa-brands fa-facebook-square"></i>
                    <i class="fa-brands fa-instagram-square"></i>
                    <i class="fa-brands fa-youtube-square"></i>
                </div>
            </aside>
        </div>

        <div class="paginador">
            <a href="#">&laquo;</a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">5</a>
            <a href="#">6</a>
            <a href="#">&raquo;</a>
        </div>

    </main>

    <footer>
        <?php include('footer.php');
        ?>
    </footer>

</body>

</html>