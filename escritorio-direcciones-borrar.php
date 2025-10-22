<?php
include 'admin/funciones.php';
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'nueva') {
        direccionGuardar($_POST['accion'], $_POST, 'escritorio-direcciones');
    } else if ($_POST['accion'] == 'editar') {
        direccionGuardar($_POST['accion'], $_POST, 'escritorio-direcciones');
    }
} else if (isset($_GET['accion']) && $_GET['accion'] == 'borrar') {
    direccionEliminar($_GET['did'], 'escritorio-direcciones');
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
                <div class="productos">
                    <h2>Borrar Dirección</h2>
                    <?php $direccion = direccionObtenerId($_GET['did']); ?>
                    <?php if ($direccion[1] == $_SESSION['usuarioId']) { ?>
                        <p>¿Estás seguro de que quieres borrar la direccion <?php print $direccion[2] ?>, <?php print $direccion[3] ?>, <?php print $direccion[4] ?>, <?php print $direccion[5] ?>, <?php print $direccion[6] ?>?
                            <a class="boton-rojo" href="escritorio-direcciones-borrar.php?accion=borrar&did=<?php print $direccion[0] ?>">Si</a> <a class="boton-rojo" href="escritorio-direcciones.php">No</a>
                        <?php } else { ?>
                            No tienes permiso para borrar la dirección seleccionada.
                        <?php } ?>

                </div>
            </section>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>

</html>