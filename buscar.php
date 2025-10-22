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
        <section class="inicio">
            <div class="seccion" id="primera-seccion">
                <div class="resultados-busqueda">
                    <?php
                    if (isset($_POST['q']) && $_POST['q'] != '') {
                        $resultados = buscar($_POST['q']);
                        if ($resultados) {

                            foreach ($resultados as $resultado) {
                                if ($resultado[0] == 'productos') {
                                    $producto = productoObtenerId($resultado[1]);
                                    print '<div><img src="imagenesproductos/' . $producto[6] . '"/><a href="producto.php?pid=' . $resultado[1] . '">' . $resultado[2] . '</a></div>';
                                } else {
                                    $receta = recetaObtenerId($resultado[1]);
                                    print '<div><img src="imagenesproductos/' . $receta[7] . '"/><a href="receta.php?rid=' . $resultado[1] . '">' . $resultado[2] . '</a></div>';
                                }
                            }
                        } else {
                            print 'La búsqueda no ha arrojado ningún resultado.';
                        }
                    } else {
                        print 'Introduce un término de búsqueda.';
                    }
                    ?>
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