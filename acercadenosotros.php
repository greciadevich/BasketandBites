<?php
include 'admin/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>NuestraTienda - Peru'sBasketandBites</title>
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

        <section class="inicio">
            <div class="seccion" id="primera-seccion">
                <img src="./pictures/peru.jpg" style="width: 500px; margin-right: 20px;">
                <div>
                    <h2>¿Quiénes somos?</h2>
                    <p>Peru'sbasketandbites está formado por entusiastas de la cultura peruana, que buscan compartir todo un catálogo de productos y experiencias, desde la recientemente descubierta y admirada gastronomía peruana, su sorprendente y milenaria historia, sus emblemáticos e increíbles paisajes, el calor y simpatía de su buena gente y por supuesto ese arte precolombino que perdura aún ahora.
                        Perú es sinónimo de recóndito, maravilloso, enigmático, natural e inolvidable. Te invitamos a que disfrutes de él, y puedas tenerlo un poquito más cerca.</p>
                </div>
            </div>

            <div class="seccion-baja">
                <div class="seccion" id="segundaseccion">
                    <h3>¿Qué Podemos Ofrecerte?</h3>
                    <p>Peru'sbasketandbites está conformado por un equipo pequeño, joven y responsable de profesionales comprometidos con la satisfacción de sus clientes y con la divulgación de productos, costumbres y arte peruano.</p>
                </div>
                <div class="seccion" id="terceraseccion">
                    <div>
                        <img src="./pictures/truck.png">
                        <h3> Entrega rápida </h3>
                        <p>Entregas en 24/48 horas(*) laborables* Consultar en FAQS detalle tiempos de tránsito.</p>
                    </div>
                    <div>
                        <img src="./pictures/24seven.png">
                        <h3> Compras 24/7</h3>
                        <p>Una tienda online abierta a todas horas. Compra cuando quieras, desde donde quieras.</p>
                    </div>
                    <div>
                        <img src="./pictures/calidad.png">
                        <h3> Calidad Garantizada</h3>
                        <p>PerúStock trabaja con los mejores proveedores del mercado, para ofrecerte excelentes productos, con la información más completa y a precios económicos.</p>
                    </div>
                </div>
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