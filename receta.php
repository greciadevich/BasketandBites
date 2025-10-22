<?php
include 'admin/funciones.php';
if (isset($_GET['accion']) && $_GET['accion'] == 'carrito') {
    $recetaTmp = recetaObtenerId($_GET['rid']);

    $carrito = json_decode($_SESSION['carrito'], true);
    $ingredientes = json_decode($recetaTmp[5], true);

    // Merge arrays and sum quantities
    $result = [];
    foreach ($carrito as $item) {
        $pid = $item['pid'];
        if (!isset($result[$pid])) {
            $result[$pid] = $item;
        } else {
            $result[$pid]['cantidad'] += $item['cantidad'];
        }
    }

    foreach ($ingredientes as $item) {
        $pid = $item['pid'];
        if (!isset($result[$pid])) {
            $result[$pid] = $item;
        } else {
            $result[$pid]['cantidad'] += $item['cantidad'];
        }
    }

    // Reset the keys to ensure a numerically indexed array
    $result = array_values($result);

    // Encode result back to JSON
    $mergedJson = json_encode($result);
    $_SESSION['carrito'] = $mergedJson;
    mensajeAlerta('Productos añadidos a tu carrito de la compra.');
}
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
        <div class="recipe-container">
            <section class="contenido-receta">
                <?php
                $receta = recetaObtenerId($_GET['rid']);
                ?>
                <h2><?php print $receta[3] ?></h2>
                <img src="./imagenesproductos/<?php print $receta[7] ?>" alt="">
                <?php print $receta[4]; ?>
                <a class="boton-rojo" href="receta.php?rid=<?php print $_GET['rid'] ?>&accion=carrito">Añadir ingredientes a la cesta</a>

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

    </main>

    <footer>
        <?php include('footer.php');
        ?>
    </footer>

</body>

</html>