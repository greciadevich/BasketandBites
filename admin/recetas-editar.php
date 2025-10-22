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
        recetaGuardar($_POST, $_FILES['imagen']);
    }
}

?>
<!DOCTYPE html>

<head>
    <title></title>
    <link rel="stylesheet" href="admin-styles.css">
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        function addIngredientRow() {
            const tabla = document.getElementById("tablaIngredientes");
            const numeroFilas = tabla.rows.length;
            const fila = tabla.insertRow(numeroFilas);

            // Deplegable cantidad
            const celda1 = fila.insertCell(0);
            const cantidadSeleccionada = document.createElement("select");
            cantidadSeleccionada.name = "cantidades[]";
            for (let i = 1; i <= 10; i++) {
                const opcion = document.createElement("option");
                opcion.value = i;
                opcion.text = i;
                cantidadSeleccionada.appendChild(opcion);
            }
            celda1.appendChild(cantidadSeleccionada);

            // Desplegable ingredientes
            const celda2 = fila.insertCell(1);
            const ingredienteSeleccionado = document.createElement("select");
            ingredienteSeleccionado.name = "ingredientes[]";
            // const ingredientes = ["Salt", "Sugar", "Flour", "Butter", "Eggs", "Milk"];
            const ingredientes = <?php print productosDesplegableRecetas() ?>;
            for (const ingrediente of ingredientes) {
                const opcion = document.createElement("option");
                opcion.value = ingrediente.pid;
                opcion.text = ingrediente.nombre;
                ingredienteSeleccionado.appendChild(opcion);
            }
            celda2.appendChild(ingredienteSeleccionado);

            // Boton borrar
            const celda3 = fila.insertCell(2);
            const botonBorrar = document.createElement("button");
            botonBorrar.type = "button";
            botonBorrar.textContent = "Borrar";
            botonBorrar.onclick = function() {
                const fila = this.parentNode.parentNode;
                fila.parentNode.removeChild(fila);
            };
            celda3.appendChild(botonBorrar);
        }

        function borrarFila(button) {
            const fila = button.parentNode.parentNode;
            fila.parentNode.removeChild(fila);
        }
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
                <form action="recetas-editar.php" method="post" enctype="multipart/form-data">
                    <label for="titulo">Titulo</label><br />
                    <input type="text" name="titulo" placeholder="Titulo" required /><br />
                    <label for="resumen">Resumen</label><br />
                    <textarea id="resumen" name="resumen" placeholder="Resumen"></textarea>
                    <label for="cuerpo">Cuerpo</label><br />
                    <textarea id="cuerpo" name="cuerpo" placeholder="Cuerpo"></textarea>
                    <label for="ingredientes">Ingredientes</label><br />
                    <table id="tablaIngredientes">
                        <tr>
                            <th>Cantidad</th>
                            <th>Ingrediente</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>
                                <select name="cantidades[]">
                                    <!-- Quantity options -->
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
                            </td>
                            <td>
                                <select name="ingredientes[]">
                                    <?php print productosDesplegable(); ?>
                                </select>
                            </td>
                            <td>
                                <button type="button" onclick="borrarFila(this)">Borrar</button>
                            </td>
                        </tr>
                    </table>
                    <button type="button" onclick="addIngredientRow()">Nueva fila</button><br /><br />
                    <label for="fcreacion">Fecha de Creacion</label><br />
                    <input type="date" name="fcreacion" value="<?php echo date('Y-m-d'); ?>" required /><br />
                    <label for="imagen">Imagen</label><br />
                    <input type="file" name="imagen" accept="image/*" /><br />
                    <input type="submit" value="Guardar Receta" />
                    <input type="hidden" name="accion" value="guardar" />
                    <input type="hidden" name="rid" value="0" />
                    <input type="hidden" name="uid" value="<?php print $_SESSION['usuarioId'] ?>" />
                </form>
            <?php
            } else if ($_GET['accion'] == 'editar') {
                $receta = recetaObtenerId($_GET['rid']);
            ?>
                <form action="recetas-editar.php" method="post" enctype="multipart/form-data">
                    <label for="titulo">Titulo</label><br />
                    <input type="text" name="titulo" placeholder="Titulo" required value="<?php print $receta[3] ?>" /><br />
                    <label for="resumen">Resumen</label><br />
                    <textarea id="resumen" name="resumen" placeholder="Resumen"><?php print $receta[6] ?></textarea>
                    <label for="cuerpo">Cuerpo</label><br />
                    <textarea id="cuerpo" name="cuerpo" placeholder="Cuerpo"><?php print $receta[4] ?></textarea>
                    <label for="ingredientes">Ingredientes</label><br />
                    <table id="tablaIngredientes">
                        <tr>
                            <th>Cantidad</th>
                            <th>Ingrediente</th>
                            <th></th>
                        </tr>
                        <?php
                        $ingredientes = json_decode($receta[5], true);
                        foreach ($ingredientes as $ingrediente) {
                        ?>
                            <tr>
                                <td>
                                    <select name="cantidades[]">
                                        <?php for ($i = 1; $i <= 100; $i++) : ?>
                                            <option value="<?php echo $i; ?>" <?php echo $i == $ingrediente['cantidad'] ? 'selected' : ''; ?>>
                                                <?php echo $i; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="ingredientes[]">
                                        <?php print productosDesplegable($ingrediente['pid']); ?>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" onclick="borrarFila(this)">Borrar</button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                    <button type="button" onclick="addIngredientRow()">Nueva fila</button><br /><br />
                    <label for="fcreacion">Fecha de Creacion</label><br />
                    <input type="date" name="fcreacion" value="<?php print date_format(date_create($receta[2]), 'Y-m-d') ?>" required /><br />
                    <label for="imagen">Imagen</label><br />
                    <input type="file" name="imagen" accept="image/*" /><br />
                    <input type="submit" value="Guardar Receta" />
                    <input type="hidden" name="accion" value="guardar" />
                    <input type="hidden" name="rid" value="<?php print $_GET['rid'] ?>" />
                    <input type="hidden" name="uid" value="<?php print $_SESSION['usuarioId'] ?>" />
                </form>
        <?php
            }
        } else {
            print 'Error.';
        }
        ?>
        <script>
            CKEDITOR.replace('cuerpo');
            CKEDITOR.replace('resumen');
        </script>
    </main>
</body>

</html>