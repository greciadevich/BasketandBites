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
        categoriaGuardar($_POST);
    }
}

?>
<html>

<head>
    <title></title>
    <link rel="stylesheet" href="admin-styles.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
</head>

<body>
    <main>
        <?php
        include('admin-header.php');

        if (isset($_GET['accion'])) {
            if ($_GET['accion'] == 'nueva') {
                // Mostramos formulario de nuevo producto.
        ?>
                <form action="categorias-editar.php" method="post">
                    <label for="nombre">Nombre</label><br />
                    <input type="text" name="nombre" placeholder="Nombre" /><br />
                    <label for="padre">Categoria Padre</label><br />
                    <select name="padre">
                        <option value="0">Sin padre</option>
                        <?php print categoriasDesplegableSoloL1() ?>
                    </select><br />
                    <input type="submit" value="Guardar" />
                    <a href="categorias.php" class="boton">Cancelar</a>
                    <input type="hidden" name="accion" value="guardar" />
                    <input type="hidden" name="cid" value="<?php isset($_GET['cid']) ? print $_GET['cid'] : print '0'; ?>" />
                </form>
            <?php
            } else if ($_GET['accion'] == 'editar') {
                $categoria = categoriasObtenerId($_GET['cid']);
            ?>
                <form action="categorias-editar.php" method="post">
                    <label for="nombre">Nombre</label><br />
                    <input type="text" name="nombre" placeholder="Nombre" value="<?php print $categoria[1] ?>" /><br />
                    <label for="padre">Categoria Padre</label><br />
                    <select name="padre">
                        <option value="0">Sin padre</option>
                        <?php print categoriasDesplegableSoloL1($categoria[2]) ?>
                    </select><br />
                    <input type="submit" value="Guardar" />
                    <a href="categorias.php" class="boton">Cancelar</a>
                    <input type="hidden" name="accion" value="guardar" />
                    <input type="hidden" name="cid" value="<?php isset($_GET['cid']) ? print $_GET['cid'] : print '0'; ?>" />
                </form>
        <?php
            }
        } else {
            print 'Error.';
        }
        ?>
    </main>
</body>

</html>