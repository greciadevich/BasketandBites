<?php
include 'admin/funciones.php';
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'nueva') {
        direccionGuardar($_POST['accion'], $_POST, 'escritorio-direcciones');
    } else if ($_POST['accion'] == 'editar') {
        direccionGuardar($_POST['accion'], $_POST, 'escritorio-direcciones');
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Escritorio - Peru'sBasketandBites</title>
    <?php include('head.php'); ?>
    <script>
        function toggleProvincia() {
            var selectPais = document.getElementById('pais');
            var provinciaEspana = document.querySelectorAll('.provincia_espana');
            var provincia = document.querySelectorAll('.provincia');

            if (selectPais.value === 'España') {
                provinciaEspana.forEach(function(element) {
                    element.style.display = 'inline-block';
                });
                provincia.forEach(function(element) {
                    element.style.display = 'none';
                });
            } else {
                provinciaEspana.forEach(function(element) {
                    element.style.display = 'none';
                });
                provincia.forEach(function(element) {
                    element.style.display = 'inline-block';
                });
            }
        }
    </script>
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
                    <?php if ($_GET['accion'] == 'nueva') { ?>
                        <h2>Nueva Dirección</h2>
                        <form action="escritorio-direcciones-editar.php" method="post" class="carrito_form">
                            <label for="calle">Calle, numero, piso, ...: </label><br/><input type="text" name="calle" placeholder="Calle, numero, piso, ..." required /><br />
                            <label for="codigopostal">Código Postal: </label><br/><input type="text" name="codigopostal" placeholder="Codigo Postal" required /></br />
                            <label for="pais">País: </label><br/><?php print direccionesSelectPais('España') ?><br />
                            <label for="provincia" class="provincia">Provincia: </label><br/><input type="text" name="provincia" placeholder="provincia" class="provincia" />
                            <label for="provincia_espana" class="provincia_espana">Provincia: </label><br/><?php print direccionesSelectProvincia('nueva') ?><br />
                            <label for="ciudad">Ciudad: </label><br/><input type="text" name="ciudad" placeholder="Ciudad" required /><br />
                            <input type="hidden" name="accion" value="nueva" />
                            <input type="hidden" name="uid" value="<?php print $_SESSION['usuarioId'] ?>" />
                            <input type="submit" value="Guardar" />
                        </form>
                    <?php } else { ?>
                        <h2>Editar Dirección</h2>
                        <form action="escritorio-direcciones-editar.php" method="post" class="carrito_form">
                            <?php $direccion = direccionObtenerId($_GET['did']); ?>
                            <label for="calle">Calle, numero, piso, ...: </label> <input type="text" name="calle" placeholder="Calle, numero, piso, ..." required value="<?php print $direccion[2]; ?>" /><br />
                            <label for="codigopostal">Código Postal: </label><input type="text" name="codigopostal" placeholder="Codigo Postal" required value="<?php print $direccion[3]; ?>" /></br />
                            <label for="pais">País: </label><?php print direccionesSelectPais($direccion[6]) ?><br />
                            <label for="provincia" class="provincia" <?php $direccion[6] == 'España' ? print 'style="display:none"': print 'style="display:inline-block"'; ?>>Provincia: </label> <input type="text" id="provincia" name="provincia" placeholder="provincia" value="<?php print $direccion[5]; ?>" class="provincia" <?php $direccion[6] == 'España' ? print 'style="display:none"': print 'style="display:inline-block"'; ?>/>
                            <label for="provincia_espana" class="provincia_espana" <?php $direccion[6] == 'España' ? print 'style="display:inline-block"': print 'style="display:none"'; ?>>Provincia: </label><?php print direccionesSelectProvincia($direccion[5]) ?><br />
                            <label for="ciudad">Ciudad: </label><input type="text" name="ciudad" placeholder="Ciudad" required value="<?php print $direccion[4]; ?>" /><br />
                            <input type="hidden" name="accion" value="editar" />
                            <input type="hidden" name="uid" value="<?php print $_SESSION['usuarioId'] ?>" />
                            <input type="hidden" name="did" value="<?php print $direccion[0] ?>" />
                            <input type="submit" value="Guardar" />
                        </form>
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