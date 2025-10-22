<?php
include 'admin/funciones.php';
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'guardar')
        usuarioGuardar($_POST);
}
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
                <div class="escritorio">
                    <h2>Datos</h2>
                    <p>A continuación se mostrarán tus datos personales. Puedes cambiarlos en cualquier momento.</p>
                    <?php
                    $usuario = usuarioObtenerId($_SESSION['usuarioId']);
                    ?>
                    <form action="escritorio-datos.php" method="post">
                        <form action="" method="post">
                            <label for="nombre">Nombre</label><br />
                            <input type="text" placeholder="Nombre" name="nombre" required value="<?php print $usuario[1] ?>" /><br />
                            <label for="apellidos">Apellidos</label><br />
                            <input type="text" placeholder="Apellidos" name="apellidos" required value="<?php print $usuario[2] ?>" /><br />
                            <label for="email">Email</label><br />
                            <input type="email" placeholder="Email" name="email" required value="<?php print $usuario[3] ?>" /><br />
                            <label for="telefono">Telefono</label><br />
                            <input type="text" placeholder="Telefono" name="telefono" value="<?php print $usuario[5] ?>" /><br />
                            <input type="submit" value="Guardar" />
                            <input type="hidden" name="destino" value="escritorio" />
                            <input type="hidden" name="accion" value="guardar" />
                            <input type="hidden" name="tipo" value="editar" />
                            <input type="hidden" name="rol" value="<?php print $usuario[6] ?>" />
                            <input type="hidden" name="uid" value="<?php print $_SESSION['usuarioId'] ?>" />
                        </form>
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