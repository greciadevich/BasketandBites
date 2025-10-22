<?php
include 'admin/funciones.php';

if (isset($_GET['accion'])) {
    if ($_GET['accion'] == 'anadir-carrito')
        anadirCarrito($_GET['pid'], 1);
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

                    <h2>Productos</h2>
                    <?php
                    $categoria = isset($_GET['cid']) ? $_GET['cid'] : 0;
                    print $productosTienda = productosTienda($categoria, 0);
                    if (empty($productosTienda)) {
                    ?>
                        <h3>No existen productos en la categoría seleccionada.</h3>
                        <!-- <div class="producto">
                            <img src="./pictures/p1.png" alt="productos-container">
                            <a href="">
                                <h3>Inca Kola 300ml</h3>
                            </a>
                            <span class="precio">50€</span>
                            <a href="" class="anadir-carrito">Añadir al carrito</a>
                        </div>
                        <div class="producto">
                            <img src="./pictures/p1.png" alt="productos-container">
                            <a href="">
                                <h3>Inca Kola 300ml</h3>
                            </a>
                            <span class="precio">50€</span>
                            <a href="" class="anadir-carrito">Añadir al carrito</a>
                        </div>
                        <div class="producto">
                            <img src="./pictures/p1.png" alt="productos-container">
                            <a href="">
                                <h3>Inca Kola 300ml</h3>
                            </a>
                            <span class="precio">50€</span>
                            <a href="" class="anadir-carrito">Añadir al carrito</a>
                        </div>
                        <div class="producto">
                            <img src="./pictures/p1.png" alt="productos-container">
                            <a href="">
                                <h3>Inca Kola 300ml</h3>
                            </a>
                            <span class="precio">50€</span>
                            <a href="" class="anadir-carrito">Añadir al carrito</a>
                        </div>
                        <div class="producto">
                            <img src="./pictures/p1.png" alt="productos-container">
                            <a href="">
                                <h3>Inca Kola 300ml</h3>
                            </a>
                            <span class="precio">50€</span>
                            <a href="" class="anadir-carrito">Añadir al carrito</a>
                        </div>
                        <div class="producto">
                            <img src="./pictures/p1.png" alt="productos-container">
                            <a href="">
                                <h3>Inca Kola 300ml</h3>
                            </a>
                            <span class="precio">50€</span>
                            <a href="" class="anadir-carrito">Añadir al carrito</a>
                        </div> -->
                    <?php } ?>
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