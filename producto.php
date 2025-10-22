<?php
include 'admin/funciones.php';

if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'anadir-carrito')
        anadirCarrito($_POST['pid'], $_POST['carrito-cantidad']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Tienda - Peru'sBasketandBites</title>
    <?php include('head.php'); ?>
</head>

<body>
    <header class="header-container">
        <?php include('nav.php'); ?>
    </header>
    <main id="tienda">
        <?php include('menu.php'); ?>
        <div class="folleto-tienda">
            <img src="./pictures/imagen01.png" alt="imagen01">
            <img src="./pictures/imagen02.png" alt="imagen02">
            <img src="./pictures/imagen03.png" alt="imagen03">
            <img src="./pictures/imagen04.png" alt="imagen04">

        </div>
        <div class="tienda-container inicio">
            <section class="col-tienda-izquierda">
                <div class="categorias">
                    <h2>Categorías</h2>
                    <?php
                    print $categoriasmenu = categoriasMenu(0);
                    if (empty($categoriasmenu)) {
                        // Para pruebas. Si no hay ninguna categoria creada, mostramos estas para temas visuales.
                    ?>
                        <ul>
                            <li class="menu-padre"><span>Bebidas</span>
                                <ul class="menu-hijo">
                                    <li>Zumos-Jugos</li>
                                    <li>Refrescos Carbonatados</li>
                                    <li>Licores</li>
                                    <li>Infusiones</li>
                                    <li>Cervezas</li>
                                    <li>Vinos</li>
                                </ul>
                            </li>
                            <li class="menu-padre"><span>Productos frescos</span>
                                <ul class="menu-hijo">
                                    <li>Frutas</li>
                                    <li>Verduras</li>
                                    <li>Ajies</li>
                                    <li>Lacticos</li>
                                    <li>Embutidos</li>
                                    <li>Ajies</li>
                                </ul>
                            </li>
                            <li class="menu-padre"><span>Alimentación</span>
                                <ul class="menu-hijo">
                                    <li>Granos, cereales y semillas</li>
                                    <li>Condimentos</li>
                                    <li>Salsa peruanas</li>
                                    <li>Alimentos deshidratados</li>
                                    <li>Harinas</li>
                                    <li>Aderezos</li>
                                    <li>Desayuno</li>
                                    <li>Platos preparados</li>
                                    <li>Galletas, Snacks, Chocolates</li>
                                    <li>Salsa peruanas</li>
                                </ul>
                            </li>
                        </ul>
                    <?php
                    }
                    ?>
                </div>
            </section>

            <section class="col-tienda-derecha">
                <div class="productos">
                    <?php $producto = productoObtenerArrayId($_GET['pid']); ?>
                    <!-- Array
(
    [0] => 6
    [1] => 7
    [2] => Producto 1
    [3] => 100
    [4] => 2.00
    [5] => 
Inca Kola rica y refrescante



    [6] => 6664798bb9720.jpg
) -->
                    <h2><?php print $producto[2] ?></h2>
                    <div class="col-producto-izquierda">
                        <?php if ($producto[6] == '') { ?>
                            <img src="pictures/noimage.jpg" />
                        <?php } else { ?>
                            <img src="imagenesproductos/<?php print $producto[6] ?>" />
                        <?php } ?>

                    </div>
                    <div class="col-producto-derecha">
                        <div class="producto-descripcion">
                            <?php print $producto[5]; ?>
                        </div>
                        <div class="producto-precio">
                            Precio: <?php print $producto[4] ?>&euro;
                        </div>
                        <form action="" method="post">
                            <select name="carrito-cantidad" class="carrito-cantidad">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                            <input type="submit" value="Añadir al carrito" class="anadir-carrito" />
                            <input type="hidden" name="accion" value="anadir-carrito" />
                            <input type="hidden" name="pid" value="<?php print $producto[0]; ?>" />
                        </form>
                    </div>
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