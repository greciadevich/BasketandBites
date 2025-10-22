<?php
// SOLO CONSULTAS SQL
// Crear consultas multiidioma. Variable lang guardada en $_SESSION. WHERE idioma = $lang
include "conexion.php";

// Función que lee el archivo SQL y lo ejecuta para crear las tablas de la base de datos.
function instalar() {
	$conn = crearConexion();
	$query = file_get_contents('database.sql');

	if (mysqli_multi_query($conn, $query) === TRUE) {
		cerrarConexion($conn);
		return 'La base de datos se ha instalado correctamente.';
	} else {
		cerrarConexion($conn);
		return 'Ha habido un error al instalar la base de datos.';
	}
}

function demo() {
	$conn = crearConexion();
	$query = file_get_contents('demo.sql');

	if (mysqli_multi_query($conn, $query) === TRUE) {
		cerrarConexion($conn);
		return 'El contenido demo se ha instalado correctamente.';
	} else {
		cerrarConexion($conn);
		return 'Ha habido un error al instalar el contenido demo.';
	}
}
// USUARIOS
// Función que comprueba su un usuario existe y coincide con su contraseña.
function usuarioCredenciales($email, $password) {
	$conn = crearConexion();
	$query = 'SELECT id FROM usuarios WHERE email="' . $email . '" AND password="' . md5($password) . '";';
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		// usuario existe y obtenemos sus datos
		$usuarioActual = $result->fetch_row();
		cerrarConexion($conn);
		return $usuarioActual[0];
	} else {
		cerrarConexion($conn);
		// usuario NO existe o password NO es correcto
		return (false);
	}
}

// Función que comprueba si ya existe un usuario con ese email asociado
function usuarioExiste($email) {
	$conn = crearConexion();
	$query = 'SELECT id FROM usuarios WHERE email="' . $email . '";';
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		// usuario existe
		return (true);
	} else {
		cerrarConexion($conn);
		// usuario NO existe
		return (false);
	}
}

// Función que devuelve el rol, nombre y apellidos de un usuario a partir de su ID
function usuarioRolNombreApellidos($uid) {
	$conn = crearConexion();
	$query = 'SELECT rol, nombre, apellidos FROM usuarios WHERE id="' . $uid . '";';
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		// usuario existe y obtenemos su rol
		$usuarioRolNombreApellidos = $result->fetch_row();
		cerrarConexion($conn);
		return $usuarioRolNombreApellidos;
	} else {
		cerrarConexion($conn);
		// usuario NO existe
		return (false);
	}
}

function usuarioNuevo($nombre, $apellidos, $email, $telefono, $password, $rol, $destino) {
	$conn = crearConexion();

	$query = 'INSERT INTO usuarios (nombre, apellidos, email, telefono, password, rol) VALUES ("' . $nombre . '", "' . $apellidos . '", "' . $email . '", "' . $telefono . '", "' . md5($password) . '", "' . $rol . '")';

	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Nuevo usuario guardado correctamente.');
		if ($destino == 'instalar') {
			$destino = 'index';
		}
		header('Location: ' . $destino . '.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al guardar el nuevo usuario.');
		header('Location: ' . $destino . '.php');
		exit;
	}
	return false;
}

function usuarioEditar($uid, $nombre, $apellidos, $email, $telefono, $rol, $destino) {
	$conn = crearConexion();

	$query = 'UPDATE usuarios SET nombre = "' . $nombre . '", apellidos = "' . $apellidos . '", email = "' . $email . '", telefono = "' . $telefono . '", rol = "' . $rol . '" WHERE id ="' . $uid . '"';

	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Usuario editado correctamente.');
		header('Location: ' . $destino . '.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al editar el usuario.');
		header('Location: ' . $destino . '.php');
		exit;
	}
	return false;
}

function usuariosObtener() {
	$conn = crearConexion();

	$query = 'SELECT * FROM usuarios';
	$result = $conn->query($query);
	$usuarios = array();
	while ($fila = $result->fetch_row()) {
		$usuarios[] = $fila;
	}
	cerrarConexion($conn);
	return $usuarios;
}

function usuarioObtenerId($uid) {
	$conn = crearConexion();

	$query = 'SELECT * FROM usuarios WHERE id = "' . $uid . '"';
	$result = $conn->query($query);
	$usuario = $result->fetch_row();
	cerrarConexion($conn);
	return $usuario;
}

function usuarioEliminarCons($uid) {
	$conn = crearConexion();

	$query = 'DELETE FROM usuarios WHERE id = "' . $uid . '"';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('El usuario ha sido borrado.');
		header('Location: usuarios.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al borrar el usuario.');
		header('Location: usuario.php');
		exit;
	}
	return false;
}

// CATEGORIAS
// Funci'on que comprueba que una categoría existe. Se usará para saber si una categoria es nueva o está siendo editada.
function categoriaExiste($cid) {
	$conn = crearConexion();
	$query = 'SELECT id FROM categorias WHERE id="' . $cid . '";';
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		// Categoria existe. No necesitamos mas datos. Devolvemos true.
		cerrarConexion($conn);
		return (true);
	} else {
		cerrarConexion($conn);
		// Categoria NO existe.
		return (false);
	}
}

// función que guarda una nueva categoría en la base de datos.
function categoriaNueva($nombre, $padre) {
	$conn = crearConexion();

	$query = 'INSERT INTO categorias (nombre, padre) VALUES ("' . $nombre . '", "' . $padre . '")';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Nueva categoría guardada correctamente.');
		header('Location: categorias.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al guardar la nueva categoría.');
		header('Location: categorias.php');
		exit;
	}
	return false;
}

// Función que guarda los cambios realizados en una categoría.
function categoriaEditar($cid, $nombre, $padre) {
	$conn = crearConexion();

	$query = 'UPDATE categorias SET nombre = "' . $nombre . '", padre = "' . $padre . '" WHERE id = "' . $cid . '"';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Categoría editada correctamente.');
		header('Location: categorias.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al editar la categoría.');
		header('Location: categorias.php');
		exit;
	}
	return false;
}

// Función que borra la categoría con el id = $cid
function categoriaEliminarCons($cid) {
	$conn = crearConexion();

	$query = 'DELETE FROM categorias WHERE id = "' . $cid . '" OR padre = "' . $cid . '"';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('La categoría ha sido borrada.');
		header('Location: categorias.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al borrar la categoría.');
		header('Location: categorias.php');
		exit;
	}
	return false;
}


// Función para obtener todas las categorias pudiendo filtrar por su padre
function categoriasObtener($padre) {
	$conn = crearConexion();
	// Si el valor de $padre es -1, devolvemos todas las categorias.
	// En caso de ser distinto de -1, devolvemos los hijos de $padre.
	// El valor 0 indica que devolvemos solo las categorias de primer nivel.
	if ($padre > -1)
		$query = 'SELECT id, nombre, padre FROM categorias where padre=' . $padre;
	else
		$query = 'SELECT id, nombre, padre FROM categorias';
	$result = $conn->query($query);
	$categorias = array();
	while ($fila = $result->fetch_row()) {
		$categorias[] = $fila;
	}
	cerrarConexion($conn);
	return $categorias;
}

// Función para obtener datos de una categoria a partir de su ID
function categoriasObtenerId($cid) {
	$conn = crearConexion();
	$query = 'SELECT id, nombre, padre FROM categorias where id=' . $cid;
	$result = $conn->query($query);
	$categoria = $result->fetch_row();
	cerrarConexion($conn);
	return $categoria;
}

// Función que devuelve únicamente el nombre de una categoría a partir de su ID
function categoriasObtenerNombre($cid) {
	$conn = crearConexion();
	$query = 'SELECT nombre FROM categorias where id=' . $cid;

	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		// Categoria existe. Devolvemos el nombre.
		$categoria = $result->fetch_row();
		cerrarConexion($conn);
		return ($categoria[0]);
	} else {
		cerrarConexion($conn);
		// Categoria NO existe.
		return (false);
	}
	return false;
}

// PRODUCTOS
// Función para obtener todos los productos, pudiendo filtrar por categoria
function productosObtener($cid = 0, $cantidad = 0) {
	$conn = crearConexion();
	$query = 'SELECT * FROM productos';
	if ($cid)
		$query .= ' WHERE cid = "' . $cid . '" ORDER BY id DESC';
	if ($cantidad > 0)
		$query .= ' ORDER BY id DESC LIMIT ' . $cantidad;

	$result = $conn->query($query);
	$productos = array();
	while ($fila = $result->fetch_row()) {
		$productos[] = $fila;
	}
	cerrarConexion($conn);
	return $productos;
}

function productoExiste($pid) {
	$conn = crearConexion();
	$query = 'SELECT id FROM productos WHERE id="' . $pid . '";';
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		// Producto existe. No necesitamos mas datos. Devolvemos true.
		cerrarConexion($conn);
		return (true);
	} else {
		cerrarConexion($conn);
		// Producto NO existe.
		return (false);
	}
}
// función que guarda una nueva categoría en la base de datos.
function productoNuevo($nombre, $categoria, $stock, $precio, $descripcion, $nuevaimagen) {
	$conn = crearConexion();

	$query = 'INSERT INTO productos (nombre, cid, stock, precio, descripcion, imagen) VALUES ("' . $nombre . '", "' . $categoria . '", "' . $stock . '", "' . $precio . '", "' . $descripcion . '", "' . $nuevaimagen . '")';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Nuevo producto guardado correctamente.');
		header('Location: productos.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al guardar el nuevo producto.');
		header('Location: productos.php');
		exit;
	}
	return false;
}

// Función que guarda los cambios realizados en una categoría.
function productoEditar($pid, $nombre, $cid, $stock, $precio, $descripcion, $nuevaimagen) {
	$conn = crearConexion();

	$query = 'UPDATE productos SET nombre = "' . $nombre . '", cid = "' . $cid . '", stock = "' . $stock . '", precio = "' . $precio . '", descripcion = "' . $descripcion . '", imagen = "' . $nuevaimagen . '" WHERE id = "' . $pid . '"';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Producto editado correctamente.');
		header('Location: productos.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al editar el producto.');
		header('Location: productos.php');
		exit;
	}
	return false;
}

function productoObtenerId($pid) {
	$conn = crearConexion();

	$query = 'SELECT * FROM productos WHERE id = "' . $pid . '"';
	$result = $conn->query($query);
	$producto = $result->fetch_row();
	cerrarConexion($conn);
	return $producto;
}

function productoEliminarCons($pid) {
	$conn = crearConexion();

	$query = 'DELETE FROM productos WHERE id = "' . $pid . '"';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('El producto ha sido borrado.');
		header('Location: productos.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al borrar el producto.');
		header('Location: productos.php');
		exit;
	}
	return false;
}

// RECETAS
function recetaExiste($rid) {
	$conn = crearConexion();
	$query = 'SELECT id FROM recetas WHERE id="' . $rid . '";';
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		// Receta existe. No necesitamos mas datos. Devolvemos true.
		cerrarConexion($conn);
		return (true);
	} else {
		cerrarConexion($conn);
		// Receta NO existe.
		return (false);
	}
}

function recetasObtener() {
	$conn = crearConexion();

	$query = 'SELECT * FROM recetas ORDER BY fcreacion DESC';
	$result = $conn->query($query);
	$recetas = array();
	while ($fila = $result->fetch_row()) {
		$recetas[] = $fila;
	}
	cerrarConexion($conn);
	return $recetas;
}

function recetaObtenerId($rid) {
	$conn = crearConexion();

	$query = 'SELECT * FROM recetas WHERE id = "' . $rid . '"';
	$result = $conn->query($query);
	$receta = $result->fetch_row();
	cerrarConexion($conn);
	return $receta;
}

function recetaNueva($titulo, $resumen, $cuerpo, $fcreacion, $uid, $cantidades, $ingredientes, $imagen) {
	$conn = crearConexion();

	$ingredientesTabla = [];
	for ($i = 0; $i < count($cantidades); $i++) {
		$ingredientesTabla[] = [
			'pid' => $ingredientes[$i],
			'cantidad' => $cantidades[$i]
		];
	}

	$ingredientesJson = mysqli_real_escape_string($conn, json_encode($ingredientesTabla));
	$query = 'INSERT INTO recetas (titulo, resumen, cuerpo, ingredientes, fcreacion, uid, imagen) VALUES ("' . $titulo . '", "' . $resumen . '", "' . $cuerpo . '", "' . $ingredientesJson . '", "' . $fcreacion . '", "' . $uid . '", "' . $imagen . '")';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Nueva receta guardada correctamente.');
		header('Location: recetas.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al guardar la nueva receta.');
		header('Location: recetas.php');
		exit;
	}
	return false;
}

function recetaEditar($rid, $titulo, $resumen, $cuerpo, $fcreacion, $uid, $cantidades, $ingredientes) {
	$conn = crearConexion();

	$ingredientesTabla = [];
	for ($i = 0; $i < count($cantidades); $i++) {
		$ingredientesTabla[] = [
			'pid' => $ingredientes[$i],
			'cantidad' => $cantidades[$i]
		];
	}

	$ingredientesJson = mysqli_real_escape_string($conn, json_encode($ingredientesTabla));
	$query = 'UPDATE recetas SET titulo = "' . $titulo . '", resumen = "' . $resumen . '", cuerpo = "' . $cuerpo . '", ingredientes = "' . $ingredientesJson . '", fcreacion = "' . $fcreacion . '", uid = "' . $uid . '" WHERE id = "' . $rid . '"';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Receta editada correctamente.');
		header('Location: recetas.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al editar la receta.');
		header('Location: recetas.php');
		exit;
	}
	return false;
}

function recetaEliminarCons($rid) {
	$conn = crearConexion();

	$query = 'DELETE FROM recetas WHERE id = "' . $rid . '"';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('La receta ha sido borrada.');
		header('Location: recetas.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al borrar la receta.');
		header('Location: recetas.php');
		exit;
	}
	return false;
}

// DIRECCIONES
function direccionGuardarNueva($direccion, $destino) {
	$conn = crearConexion();

	if ($direccion['pais'] == 'España')
		$direccion['provincia'] = $direccion['provincia_espana'];

	$query = 'INSERT INTO direcciones (uid, calle, codigopostal, ciudad, provincia, pais) VALUES ("' . $direccion['uid'] . '", "' . $direccion['calle'] . '", "' . $direccion['codigopostal'] . '", "' . $direccion['ciudad'] . '", "' . $direccion['provincia'] . '", "' . $direccion['pais'] . '")';

	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Nueva dirección guardada correctamente.');
		header('Location: ' . $destino . '.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al guardar la nueva dirección.');
		header('Location: ' . $destino . '.php');
		exit;
	}
	return false;
}

function direccionesObtener($uid = 0) {
	$conn = crearConexion();

	$query = 'SELECT * FROM direcciones';
	if ($uid != 0)
		$query .= ' WHERE uid="' . $uid . '"';
	$result = $conn->query($query);
	$direcciones = array();
	while ($fila = $result->fetch_row()) {
		$direcciones[] = $fila;
	}
	cerrarConexion($conn);
	return $direcciones;
}

function direccionObtenerId($did) {
	$conn = crearConexion();

	$query = 'SELECT * FROM direcciones WHERE id = "' . $did . '"';
	$result = $conn->query($query);
	$direccion = $result->fetch_row();
	cerrarConexion($conn);
	return $direccion;
}

function direccionGuardarEditar($direccion, $destino) {
	$conn = crearConexion();

	if ($direccion['pais'] == 'España')
		$direccion['provincia'] = $direccion['provincia_espana'];
	$query = 'UPDATE direcciones SET uid = "' . $direccion['uid'] . '", calle = "' . $direccion['calle'] . '", codigopostal = "' . $direccion['codigopostal'] . '", ciudad = "' . $direccion['ciudad'] . '", provincia = "' . $direccion['provincia'] . '", pais = "' . $direccion['pais'] . '" WHERE id ="' . $direccion['did'] . '"';

	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Dirección editada correctamente.');
		header('Location: ' . $destino . '.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al editar la dirección.');
		header('Location: ' . $destino . '.php');
		exit;
	}
	return false;
}

function direccionEliminarCons($did, $destino) {
	$conn = crearConexion();

	$query = 'DELETE FROM direcciones WHERE id = "' . $did . '"';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('La dirección ha sido borrada.');
		header('Location: ' . $destino . '.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al borrar la dirección.');
		header('Location: ' . $destino . '.php');
		exit;
	}
	return false;
}

// PEDIDOS

function pedidoGuardarCons($pedido) {
	$conn = crearConexion();
	$productosJson = mysqli_real_escape_string($conn, json_encode($pedido['productos']));

	// $query = 'INSERT INTO pedidos (uid, did, productos, fpedido, enviado, importe) VALUES ("' . $pedido['uid'] . '", "' . $pedido['did'] . '", "' . $productosJson . '", "' . $pedido['fpedido'] . '", "' . $pedido['enviado'] . '", "' . $pedido['importe'] . '")';
	$query = 'INSERT INTO pedidos (uid, did, productos, fpedido, enviado, importe) VALUES (?, ?, ?, ?, ?, ?)';

	$stmt = $conn->prepare($query);

	// Verificar si la preparación de la consulta fue exitosa
	if ($stmt === false) {
		cerrarConexion($conn);
		mensajeAlerta('Error al preparar la consulta: ' . $conn->error);
		return false;
	}

	// Vincular los parámetros
	$stmt->bind_param("iisssi", $pedido['uid'], $pedido['did'], $productosJson, $pedido['fpedido'], $pedido['enviado'], $pedido['importe']);

	// Ejecutar la consulta
	if ($stmt->execute() === TRUE) {
		// Obtener el ID del último registro insertado
		$last_id = $conn->insert_id;

		cerrarConexion($conn);
		mensajeAlerta('El pedido ha sido creado con número: ' . $last_id);

		return $last_id;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al crear el pedido: ' . $stmt->error);

		return false;
	}
}

function pedidosUsuario($uid) {
	$conn = crearConexion();

	$query = 'SELECT * FROM pedidos';
	if ($uid != 0)
		$query .= ' WHERE uid="' . $uid . '"';
	$result = $conn->query($query);
	$pedidos = array();
	while ($fila = $result->fetch_row()) {
		$pedidos[] = $fila;
	}
	cerrarConexion($conn);
	return $pedidos;
}

function buscarConsulta($q) {
	$conn = crearConexion();

	$query = 'SELECT "productos" AS tabla, id, nombre FROM productos WHERE nombre LIKE "%' . $q . '%"
				UNION
				SELECT "recetas" AS tabla, id, titulo FROM recetas WHERE titulo LIKE "%' . $q . '%"';
	$result = $conn->query($query);
	$resultados = array();
	while ($fila = $result->fetch_row()) {
		$resultados[] = $fila;
	}
	cerrarConexion($conn);
	return $resultados;
}

function pedidoEliminarCons($pid) {
	$conn = crearConexion();

	$query = 'DELETE FROM pedidos WHERE id = "' . $pid . '"';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('El pedido ha sido borrado.');
		header('Location: pedidos.php');
		exit;
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al borrar el pedido.');
		header('Location: pedidos.php');
		exit;
	}
	return false;
}

function pedidoEnviarCons($pid) {
	$conn = crearConexion();

	$query = 'UPDATE pedidos SET fenvio = "' . date('Y-m-d') . '", enviado = 1 WHERE id = "' . $pid . '"';
	if ($conn->query($query) === TRUE) {
		cerrarConexion($conn);
		mensajeAlerta('Pedido enviado.');
	} else {
		cerrarConexion($conn);
		mensajeAlerta('Ha habido un error al marcar el pedido como enviado.');
	}
	return false;
}
