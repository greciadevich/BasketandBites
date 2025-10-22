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

        <div class="formulario inicio">
            <div class="container">
                <div class="contactoform">
                    <h3>Déjanos Un Mensaje </h3>
                    <p>Si tienes cualquier consulta, sugerencia o problema, no dudes en ponerte en contacto mediante este formulario. El equipo de Perubasketandbites te responderá lo antes posible.</p>
                    <form action="/submit_form" method="POST">
                        <div class="form-fila1">
                            <label for="name">Nombre*</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-fila2">
                            <label for="email">Tu Email*</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-fila3">
                            <label for="message">Mensaje:</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        <div class="form-fila4">
                            <button type="submit">Enviar Mensaje</button>
                        </div>
                    </form>
                </div>
                <div class="formulariodos">
                    <h3>Nuestra Tienda</h3>
                    <hr class="linea-separadora">
                    <div class="sidebar-3">
                        <p>Tienda física
                            Plaza Font Nova 2, local B - Reus
                            623 10 18 00 </p>
                        <p> Horario <br>
                            Lunes—Viernes: 9:30 - 14:00hrs.s / 16:30 - 21:00hrs. <br>
                            Sábados: 10:00 - 14:00hrs. / 17:30 - 21:00hrs. </p>
                        <a href="./acercadenosotros.php" class="boton-enlace">Acerca de nosotros </a>
                        <hr class="linea-separadora">
                        <h3>Nuestras novedades</h3>
                        <div class="sidebar-2">
                            <img src="./pictures/imagen1.png" alt="imagen1">
                            <img src="./pictures/imagen2.png" alt="imagen2">
                            <img src="./pictures/imagen3.png" alt="imagen3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include('footer.php');
        ?>
    </footer>

</body>

</html>