<?php
// Iniciamos sesion
// cookie_lifetime = 86400 son 24 horas
session_start([
    'cookie_lifetime' => 0,
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict'
]);

include 'funciones.php';

if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'guardar') {
        // Guardamos la categoria, nueva o existente.
        productoGuardar($_POST, $_FILES['imagen']);
    }
}

?>
<html>

<head>
    <title></title>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="admin-styles.css">
</head>

<body>
    <main>
        <?php
        include('admin-header.php');

        if (isset($_GET['accion'])) {
            if ($_GET['accion'] == 'nuevo') {
                // Mostramos formulario de nuevo producto.
        ?>
                <form action="productos-editar.php" method="post" enctype="multipart/form-data">
                    <label for="nombre">Nombre</label><br />
                    <input type="text" name="nombre" placeholder="Nombre" required /><br />
                    <label for="categoria">Categoria</label><br />
                    <select name="cid" required>
                        <?php print categoriasDesplegable() ?>
                    </select><br />
                    <label for="stock">Stock</label><br />
                    <input type="text" name="stock" placeholder="Stock" required /><br />
                    <label for="precio">Precio</label><br />
                    <input type="text" name="precio" placeholder="Precio" required /><br />
                    <label for="descripcion">Descripcion</label><br />
                    <textarea name="descripcion" id="descripcion" placeholder="Descripcion" required></textarea><br />
                    <label for="imagen">Imagen</label><br />
                    <input type="file" name="imagen" accept="image/*" /><br />
                    <input type="submit" value="Guardar Producto" />
                    <input type="hidden" name="accion" value="guardar" />
                    <input type="hidden" name="pid" value="0" />
                </form>
            <?php
            } else if ($_GET['accion'] == 'editar') {
                $producto = productoObtenerId($_GET['pid']);
            ?>
                <form action="productos-editar.php" method="post" enctype="multipart/form-data">
                    <label for="nombre">Nombre</label><br />
                    <input type="text" name="nombre" placeholder="Nombre" value="<?php print $producto[2] ?>" /><br />
                    <label for="categoria">Categoria</label><br />
                    <select name="cid">
                        <?php print categoriasDesplegable($producto[1]) ?>
                    </select><br />
                    <label for="stock">Stock</label><br />
                    <input type="text" name="stock" placeholder="Stock" value="<?php print $producto[3] ?>" /><br />
                    <label for="precio">Precio</label><br />
                    <input type="text" name="precio" placeholder="Precio" value="<?php print $producto[4] ?>" /><br />
                    <label for="descripcion">Descripcion</label><br />
                    <textarea name="descripcion" id="descripcion" placeholder="Descripcion"><?php print $producto[5] ?></textarea><br />
                    <?php
                    if ($producto[6] == '') {
                    ?>
                        <label for="imagen">Imagen</label><br />
                        <input type="file" name="imagen" accept="image/*" /><br />
                    <?php
                    } else {
                    ?>
                        <label for="imagen">Imagen</label><br />
                        <img src="../imagenesproductos/<?php print $producto[6] ?>" width=250 />
                        <input type="checkbox" name="borrarimagen" /> Borrar imagen.
                        <input type="file" name="imagen" accept="image/*" /><br />
                    <?php
                    }
                    ?>
                    <input type="submit" value="Guardar Producto" />
                    <input type="hidden" name="imagenExiste" value="<?php print $producto[6] ?>" />
                    <input type="hidden" name="accion" value="guardar" />
                    <input type="hidden" name="pid" value="<?php isset($_GET['pid']) ? print $_GET['pid'] : print '0'; ?>" />
                </form>
        <?php
            }
        } else {
            print 'Error.';
        }
        ?>
        <script>
            CKEDITOR.replace('descripcion');
        </script>
    </main>
</body>

</html>