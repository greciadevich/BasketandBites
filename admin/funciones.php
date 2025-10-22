<?php

include "consultas.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../phpmailer/src/Exception.php';
require __DIR__ . '/../phpmailer/src/PHPMailer.php';
require __DIR__ . '/../phpmailer/src/SMTP.php';

if (session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
	session_start([
		'cookie_lifetime' => 0,
		'cookie_secure' => true,
		'cookie_httponly' => true,
		'cookie_samesite' => 'Strict'
	]);
	if (!isset($_SESSION['carrito']) || $_SESSION['carrito'] == null) {
		$_SESSION['carrito'] = json_encode([]);
	}
}

function comprobarUsuario($email, $password) {
	// Comprobamos que el usuario existe.
	if ($usuarioId = usuarioCredenciales($email, $password)) {
		// Usuario existe. Obtenemos rol y guardamos id, rol, nombre y apellidos en sesion
		$usuarioRolNombreApellidos = usuarioRolNombreApellidos($usuarioId);
		$_SESSION['usuarioRol'] = $usuarioRolNombreApellidos[0];
		$_SESSION['usuarioNombre'] = $usuarioRolNombreApellidos[1];
		$_SESSION['usuarioApellidos'] = $usuarioRolNombreApellidos[2];
		$_SESSION['usuarioId'] = $usuarioId;
		// Redirigimos dependiendo del rol.
		switch ($usuarioRolNombreApellidos[0]) {
			case 'admin':
				header('Location: escritorio.php');
				exit();
				break;
			case 'editor':
				break;
			case 'encargado':
				break;
			case 'cliente':
				header('Location: escritorio.php');
				exit();
				break;
		}
		return $usuarioRolNombreApellidos[0];
	} else {
		return (false);
	}
}

function categoriaGuardar($categoria) {
	// Comprobamos si la categoria ya existe.
	if (categoriaExiste($categoria['cid'])) {
		// Categoria existe. Actualizamos sus datos.
		return (categoriaEditar($categoria['cid'], $categoria['nombre'], $categoria['padre']));
	} else {
		// Nueva categoria. La guardamos.
		return (categoriaNueva($categoria['nombre'], $categoria['padre']));
	}
}

function categoriaEliminar($categoria) {
	return (categoriaEliminarCons($categoria));
}

function categoriasMenu($activo = 0) {
	// Si $activo == 0, no hay ningun elemento activo. Mostramos todos los menus cerrados.
	$categorias = categoriasObtener(0);
	// <ul>
	// 	<li class="menu-padre"><span>Bebidas</span>
	//         <ul class="menu-hijo">
	// 			<li>Zumos-Jugos</li>
	//             <li>Refrescos Carbonatados</li>
	//         </ul>
	//     </li>
	// </ul>
	$categoriasmenu = '<ul>';
	foreach ($categorias as $categoria) {
		$categoriasmenu .= '<li class="menu-padre"><span>' . $categoria[1] . '</span>';
		$categoriashijo = categoriasObtener($categoria[0]);
		if (!empty($categoriashijo)) {
			$categoriasmenu .= '<ul class="menu-hijo">';
			foreach ($categoriashijo as $categoriahijo) {
				$categoriasmenu .= '<li><a href="tienda.php?cid=' . $categoriahijo[0] . '">' . $categoriahijo[1] . '</a></li>';
			}
			$categoriasmenu .= '</ul>';
		}
		$categoriasmenu .= '</li>';
	}
	$categoriasmenu .= '</ul>';
	return $categoriasmenu;
}

function categoriasDesplegableSoloL1($seleccionada = 0) {
	$categorias = categoriasObtener(0);
	$desplegable = '';
	foreach ($categorias as $categoria)
		if ($categoria[0] === $seleccionada)
			$desplegable .= '<option value="' . $categoria[0] . '" selected>' . $categoria[1] . '</option>';
		else
			$desplegable .= '<option value="' . $categoria[0] . '">' . $categoria[1] . '</option>';
	return $desplegable;
}

function categoriasDesplegable($seleccionada = 0) {
	$categorias = categoriasObtener(0);
	$desplegable = '';
	foreach ($categorias as $categoria) {
		$desplegable .= '<option value="' . $categoria[0] . '" disabled>' . $categoria[1] . '</option>';
		if ($categoriashijo = categoriasObtener($categoria[0])) {
			foreach ($categoriashijo as $categoriahijo) {
				if ($categoriahijo[0] === $seleccionada)
					$desplegable .= '<option value="' . $categoriahijo[0] . '" selected>- ' . $categoriahijo[1] . '</option>';
				else
					$desplegable .= '<option value="' . $categoriahijo[0] . '">- ' . $categoriahijo[1] . '</option>';
			}
		}
	}

	return $desplegable;
}

function categoriasTabla() {
	$categoriaspadre = categoriasObtener(0);
	$categoriasTabla = '<table><thead><tr><th>ID</th><th>Nombre</th><th>Padre</th><th>Acciones</th></tr></thead>';
	foreach ($categoriaspadre as $categoriapadre) {
		$categoriasTabla .= '<tr><td>' . $categoriapadre[0] . '</td><td>' . $categoriapadre[1] . '</td><td></td><td><a href="categorias-editar.php?accion=editar&cid=' . $categoriapadre[0] . '" class="boton">Editar</a> <a href="categorias-borrar.php?cid=' . $categoriapadre[0] . '" class="boton">Eliminar</a></tr>';
		$categoriashijo = categoriasObtener($categoriapadre[0]);
		foreach ($categoriashijo as $categoriahijo) {
			$categoriasTabla .= '<tr><td>' . $categoriahijo[0] . '</td><td>' . $categoriahijo[1] . '</td><td>' . categoriasObtenerNombre($categoriahijo[2]) . '</td><td><a href="categorias-editar.php?accion=editar&cid=' . $categoriahijo[0] . '" class="boton">Editar</a> <a href="categorias-borrar.php?cid=' . $categoriahijo[0] . '" class="boton">Eliminar</a></tr>';
		}
	}
	$categoriasTabla .= '</table>';
	return $categoriasTabla;
}

// USUARIOS
function usuariosTabla() {
	$usuarios = usuariosObtener();
	$usuariosTabla = '<table><thead><tr><th>ID</th><th>Nombre</th><th>Apellidos</th><th>Email</th><th>Teléfono</th><th>Rol</th><th>Acciones</th></tr></thead>';
	foreach ($usuarios as $usuario) {
		$usuariosTabla .= '<tr><td>' . $usuario[0] . '</td><td>' . $usuario[1] . '</td><td>' . $usuario[2] . '</td><td>' . $usuario[3] . '</td><td>' . $usuario[5] . '</td><td>' . $usuario[6] . '</td><td><a href="usuarios-editar.php?accion=editar&uid=' . $usuario[0] . '" class="boton">Editar</a> <a href="usuarios-borrar.php?uid=' . $usuario[0] . '" class="boton">Eliminar</a></tr>';
	}
	$usuariosTabla .= '</table>';
	return $usuariosTabla;
}

function usuarioGuardar($usuario) {
	if ($usuario['tipo'] == 'nuevo') {
		if (usuarioExiste($usuario['email'])) {
			mensajeAlerta('Ya existe un usuario con esa dirección de email');
		} else {
			usuarioNuevo($usuario['nombre'], $usuario['apellidos'], $usuario['email'], $usuario['telefono'], $usuario['password'], $usuario['rol'], $usuario['destino']);
		}
	} else if ($usuario['tipo'] == 'editar') {
		usuarioEditar($usuario['uid'], $usuario['nombre'], $usuario['apellidos'], $usuario['email'], $usuario['telefono'], $usuario['rol'], $usuario['destino']);
	}
}

function usuarioEliminar($usuario) {
	return (usuarioEliminarCons($usuario));
}

function mensajeAlerta($mensaje) {
	$_SESSION['mensaje'] = $mensaje;
	return true;
}

// PRODUCTOS
function productosTabla() {
	$productos = productosObtener();
	$productosTabla = '<table><thead><tr><th>ID</th><th>Nombre</th><th>Categoria</th><th>Stock</th><th>Precio</th><th>Descripcion</th><th>Imagen</th><th>Acciones</th></tr></thead>';
	foreach ($productos as $producto) {
		$categoria = categoriasObtenerId($producto['1']);
		$productosTabla .= '<tr><td>' . $producto[0] . '</td><td>' . $producto[2] . '</td><td>' . $categoria[1] . '</td><td>' . $producto[3] . '</td><td>' . $producto[4] . '&euro;</td><td>' . $producto[5] . '</td><td>';
		if ($producto[6])
			$productosTabla .= '<a target="_blank" href="../imagenesproductos/' . $producto[6] . '"><img height=50 src="../imagenesproductos/' . $producto[6] . '"/></a>';
		$productosTabla .= '</td><td><a href="productos-editar.php?accion=editar&pid=' . $producto[0] . '" class="boton">Editar</a> <a href="productos-borrar.php?pid=' . $producto[0] . '" class="boton">Eliminar</a></tr>';
	}
	$productosTabla .= '</table>';
	return $productosTabla;
}

function productoGuardar($producto, $imagen = null) {
	// Comprobamos si el producto ya existe.
	$nuevaimagen = '';
	if (productoExiste($producto['pid'])) {
		// Producto existe. guardamos los cambios.
		if ($imagen['size'] > 0) {
			$target_dir = "../imagenesproductos/";
			$imageFileType = strtolower(pathinfo($imagen["name"], PATHINFO_EXTENSION));
			$nuevaimagen = uniqid() . '.' . $imageFileType;

			// Check if image file is a actual image or fake image
			$check = getimagesize($imagen["tmp_name"]);
			if ($check !== false) {
				if (!move_uploaded_file($imagen["tmp_name"], $target_dir . $nuevaimagen)) {
					mensajeAlerta('Ha ocurrido un error al subir la imagen.');
				}
			} else {
				mensajeAlerta('El archivo seleccionado no es una imagen.');
			}
		} else {
			if (isset($producto['borrarimagen']))
				$nuevaimagen = '';
			else
				$nuevaimagen = $_POST['imagenExiste'];
		}
		return (productoEditar($producto['pid'], $producto['nombre'], $producto['cid'], $producto['stock'], $producto['precio'], $producto['descripcion'], $nuevaimagen));
	} else {
		// Nuevo producto. Lo guardamos.
		if ($imagen['size'] > 0) {
			$target_dir = "../imagenesproductos/";
			$imageFileType = strtolower(pathinfo($imagen["name"], PATHINFO_EXTENSION));
			$nuevaimagen = uniqid() . '.' . $imageFileType;

			// Check if image file is a actual image or fake image
			$check = getimagesize($imagen["tmp_name"]);
			if ($check !== false) {
				if (!move_uploaded_file($imagen["tmp_name"], $target_dir . $nuevaimagen)) {
					echo "Sorry, there was an error uploading your file.";
				}
			} else {
				echo "File is not an image.";
			}
		}
		return (productoNuevo($producto['nombre'], $producto['cid'], $producto['stock'], $producto['precio'], $producto['descripcion'], $nuevaimagen));
	}
}

function productoEliminar($producto) {
	return (productoEliminarCons($producto));
}

function productosDesplegable($seleccionado = 0) {
	$productos = productosObtener();
	$desplegable = '';
	foreach ($productos as $producto) {
		if ($producto[0] === $seleccionado)
			$desplegable .= '<option value="' . $producto[0] . '" selected>' . $producto[2] . '</option>';
		else
			$desplegable .= '<option value="' . $producto[0] . '">' . $producto[2] . '</option>';
	}
	return $desplegable;
}

function productosDesplegableRecetas() {
	// ["Salt", "Sugar", "Flour", "Butter", "Eggs", "Milk"]
	$productos = productosObtener();
	$desplegable = '[';
	foreach ($productos as $producto) {
		// {"quantity": 1, "ingredient": "Salt"},
		$desplegable .= '{"pid": ' . $producto[0] . ', "nombre": "' . $producto[2] . '"},';
	}
	$desplegable .= ']';
	return $desplegable;
}

function productosTienda($categoria, $cantidad) {
	$productosTienda = productosObtener($categoria, $cantidad);
	$contenido = '';
	foreach ($productosTienda as $producto) {
		$imagen = 'imagenesproductos/' . $producto[6];
		if ($imagen == 'imagenesproductos/')
			$imagen = 'pictures/noimage.jpg';
		$contenido .= '<div class="producto">
		<a href="producto.php?pid=' . $producto[0] . '"><img src="' . $imagen . '" alt="' . $producto[2] . '"></a>
		<a href="producto.php?pid=' . $producto[0] . '"><h3>' . $producto[2] . '</h3></a>
		<span class="precio">' . $producto[4] . '€</span>';
		if ($categoria == 0)
			$contenido .= '<a href="tienda.php?accion=anadir-carrito&pid=' . $producto[0] . '" class="anadir-carrito">Añadir al carrito</a></div>';
		else
			$contenido .= '<a href="tienda.php?cid=' . $categoria . '&accion=anadir-carrito&pid=' . $producto[0] . '" class="anadir-carrito">Añadir al carrito</a></div>';
	}
	return $contenido;
}

function productoObtenerArrayId($pid) {
	$producto = productoObtenerId($pid);
	return $producto;
}

// RECETAS
function recetasTabla() {
	$recetas = recetasObtener();
	$recetasTabla = '<table><thead><tr><th>ID</th><th>Titulo</th><th>Resumen</th><th>Fecha Creacion</th><th>Usuario</th><th>Acciones</th></tr></thead>';
	foreach ($recetas as $receta) {
		$usuario = usuarioObtenerId($receta[1]);
		$recetasTabla .= '<tr><td>' . $receta[0] . '</td><td>' . $receta[3] . '</td><td>' . $receta[6] . '</td><td>' . $receta[2] . '</td><td>' . $usuario[1] . '</td><td><a href="recetas-editar.php?accion=editar&rid=' . $receta[0] . '" class="boton">Editar</a> <a href="recetas-borrar.php?rid=' . $receta[0] . '" class="boton">Eliminar</a></tr>';
	}
	$recetasTabla .= '</table>';
	return $recetasTabla;
}

function recetaGuardar($receta, $imagen) {
	// Comprobamos si el usuario ya existe.
	if (recetaExiste($receta['rid'])) {
		// Receta existe. Actualizamos.
		recetaEditar($receta['rid'], $receta['titulo'], $receta['resumen'], $receta['cuerpo'], $receta['fcreacion'], $receta['uid'], $receta['cantidades'], $receta['ingredientes']);
	} else {
		// Nueva receta. La guardamos.
		if ($imagen['size'] > 0) {
			$target_dir = "../imagenesproductos/";
			$imageFileType = strtolower(pathinfo($imagen["name"], PATHINFO_EXTENSION));
			$nuevaimagen = uniqid() . '.' . $imageFileType;

			// Check if image file is a actual image or fake image
			$check = getimagesize($imagen["tmp_name"]);
			if ($check !== false) {
				if (!move_uploaded_file($imagen["tmp_name"], $target_dir . $nuevaimagen)) {
					echo "Sorry, there was an error uploading your file.";
				}
			} else {
				echo "File is not an image.";
			}
		}
		recetaNueva($receta['titulo'], $receta['resumen'], $receta['cuerpo'], $receta['fcreacion'], $receta['uid'], $receta['cantidades'], $receta['ingredientes'], $nuevaimagen);
	}
}

function recetaEliminar($receta) {
	return (recetaEliminarCons($receta));
}

function recetasSemana() {
	$recetas = recetasObtener();
	$recetasSemana = '';
	foreach ($recetas as $receta) {
		$recetasSemana .= '<article class="columnas"><img src="./imagenesproductos/' . $receta[7] . '" alt=""><h3>' . $receta[3] . '</h3>' . $receta[6] . '<a href="receta.php?rid=' . $receta[0] . '" class="boton-rojo">Leer Mas</a></article>';
	}
	return $recetasSemana;
}

// PEDIDOS
function pedidosTabla() {
	$pedidos = pedidosUsuario(0);
	$pedidosTabla = '';
	if (empty($pedidos)) {
		$pedidosTabla = 'No hay pedidos';
	} else {
		$pedidosTabla = '<table class="tablaazul"><thead><tr><th>Número</th><th>Productos</th><th>Importe</th><th>Fecha Pedido</th><th>Dirección</th><th>Enviado</th><th>Fecha Envio</th><th>Acciones</th></tr></thead>';
		foreach ($pedidos as $pedido) {
			$usuario = usuarioObtenerId($pedido[1]);
			$direccion = direccionObtenerId($pedido[2]);
			$direccionCompleta = $usuario[1] . ' ' . $usuario[2] . '<br/>' . $direccion[2] . '<br/>' . $direccion[3] . '<br/>' . $direccion[4] . '<br/>' . $direccion[5] . '<br/>' . $direccion[6];
			$productos = json_decode(stripslashes($pedido[3]), true);
			$importe = 0;
			$pedidoTabla = '<table><thead><tr><td>Producto</td><td>Cantidad</td><td>Precio</td></tr></thread>';
			foreach ($productos as $producto) {
				$importe += $producto['cantidad'] * $producto['precio'];
				$nombreProducto = productoObtenerId($producto['pid']);
				$pedidoTabla .= '<tr><td>' . $nombreProducto[2] . '</td><td>' . $producto['cantidad'] . '</td><td>' . $producto['precio'] . '</td></tr>';
			}
			$pedidoTabla .= '</table>';
			$fenvio = $pedido[6] == '' ? '' : date_format(date_create($pedido[6]), 'Y-m-d');
			$enviado = $pedido[5] == 0 ? 'Pendiente de envio' : 'Enviado';
			$pedidosTabla .= '<tr><td>' . $pedido[0] . '</td><td>' . $pedidoTabla . '</td><td>' . $importe . '&euro;</td><td>' . date_format(date_create($pedido[4]), 'Y-m-d') . '</td><td>' . $direccionCompleta . '</td><td>' . $enviado . '</td><td>' . $fenvio . '</td><td><a href="pedidos.php?accion=enviar&pid=' . $pedido[0] . '&uid=' . $pedido[1] . '" class="boton">Enviado</a> <a href="pedidos.php?pid=' . $pedido[0] . '&accion=borrar" class="boton">Eliminar</a></td></tr>';
		}
		$pedidosTabla .= '</table>';
	}
	return $pedidosTabla;
}

function anadirCarrito($pid, $cantidad) {
	if (isset($_SESSION['carrito'])) {
		// Carrito ya fue creado.
		$tempArray = json_decode($_SESSION['carrito'], true);
		// Buscamos si el elemento ya esta.
		if (!anadirCarritoExiste($tempArray, $pid, $cantidad))
			array_push($tempArray, array('pid' => $pid, 'cantidad' => $cantidad));
		$_SESSION['carrito'] = json_encode($tempArray);
	} else {
		$_SESSION['carrito'] = json_encode(array(array('pid' => $pid, 'cantidad' => (int)$cantidad)));
	}
	mensajeAlerta('Producto añadido correctamente.');
}

function anadirCarritoExiste(&$tempArray, $pid, $cantidad) {
	foreach ($tempArray as &$elemento) {
		if (isset($elemento['pid']) && $elemento['pid'] == $pid) {
			$elemento['cantidad'] = $elemento['cantidad'] + $cantidad;
			return true;
		}
	}
	return false;
}

// CARRITO COMPRA
function carritoTabla($carritoCompra) {
	$contenido = '<form method="post" action=""><table class="tablaazul"><thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Precio Total</th></tr></thead>';
	$importeTotal = 0;
	foreach ($carritoCompra as $producto) {
		// $producto['pid'];
		// $producto['cantidad'];
		$productoTmp = productoObtenerId($producto['pid']);
		$importe = $productoTmp[4] * $producto['cantidad'];
		$importeTotal = $importeTotal + $importe;
		$contenido .= '<tr><td>' . $productoTmp[2] . '<input type="hidden" name="pid[]" value="' . $producto['pid'] . '"/></td><td>' . carritoSelectCantidad($producto['cantidad'], false) . '</td><td>' . $productoTmp[4] . '&euro;</td><td>' . $importe . '&euro;</td></tr>';
	}
	$contenido .= '<tr><td colspan=2></td><td>Importe total:</td><td>' . $importeTotal . '&euro;</td></tr>';
	$contenido .= '</table>';
	$contenido .= '<input type="hidden" name="accion" value="actualizar" /><input type="submit" value="Actualizar" /> <a href="cart-direccion.php" class="boton-darkred">Dirección de envío</a></form>';
	return $contenido;
}

function carritoTablaPago($carritoCompra, $did) {
	$contenido = '<table class="tablaazul"><thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Precio Total</th></tr></thead>';
	$importeTotal = 0;
	foreach ($carritoCompra as $producto) {
		// $producto['pid'];
		// $producto['cantidad'];
		$productoTmp = productoObtenerId($producto['pid']);
		$importe = $productoTmp[4] * $producto['cantidad'];
		$importeTotal = $importeTotal + $importe;
		$contenido .= '<tr><td>' . $productoTmp[2] . '<input type="hidden" name="pid[]" value="' . $producto['pid'] . '"/></td><td>' . carritoSelectCantidad($producto['cantidad'], true) . '</td><td>' . $productoTmp[4] . '&euro;</td><td>' . $importe . '&euro;</td></tr>';
	}
	// Calculamos envio. Tarragona = 5. Cataluña = 8. Resto de España = 10. Europa = 15.
	$direccion = direccionObtenerId($did);

	if ($direccion[6] != 'España') {
		$envio = array(15, 'Internacional');
	} else if (!in_array($direccion[5], ["Barcelona", "Girona", "Lérida", "Tarragona"])) {
		$envio = array(10, 'Nacional');
	} else if ($direccion[5] != 'Tarragona') {
		$envio = array(8, 'Regional');
	} else {
		$envio = array(5, 'Local');
	}
	$contenido .= '<tr><td colspan=3>Gastos de envío (' . $envio[1] . ')</td><td>' . $envio[0] . '&euro;</td></tr>';
	$importeTotal += $envio[0];
	$contenido .= '<tr><td colspan=2></td><td>Importe total:</td><td>' . $importeTotal . '&euro;</td></tr>';
	$contenido .= '</table>';
	$contenido .= '<form method="post" action="cart-pago.php">';
	$contenido .= '<input type="hidden" name="did" value="' . $did . '"/>';
	$contenido .= '<input type="hidden" name="total" value="' . $importeTotal . '"/>';
	$contenido .= '<a href="cart-direccion.php" class="boton-darkred">Volver</a> <input type="submit" value="Pagar"/></form>';
	return $contenido;
}

function carritoActualizar($carrito) {
	for ($i = 0; $i < count($carrito['pid']); $i++) {
		if ($carrito['cantidades'][$i] != 0) {
			$carritoNuevo[] = [
				'pid' => $carrito['pid'][$i],
				'cantidad' => $carrito['cantidades'][$i]
			];
		}
	}
	if (!empty($carritoNuevo))
		$_SESSION['carrito'] = json_encode($carritoNuevo);
	else
		$_SESSION['carrito'] = json_encode([]);
	mensajeAlerta('Carrito actualizado.');
}

function carritoSelectCantidad($cantidad, $desactivado) {
	if ($desactivado)
		$contenido = '<select class="carrito-cantidad" name="cantidades[]" disabled>';
	else
		$contenido = '<select class="carrito-cantidad" name="cantidades[]">';
	$contenido .= '<option value="0">0 - Eliminar</option>';
	for ($i = 1; $i <= 100; $i++) {
		if ($cantidad == $i)
			$contenido .= '<option value="' . $i . '" selected>' . $i . '</option>';
		else
			$contenido .= '<option value="' . $i . '">' . $i . '</option>';
	}
	$contenido .= '</select>';
	return $contenido;
}

// DIRECCIONEs
function direccionesTabla($uid) {
	$direcciones = direccionesObtener($uid);
	if (empty($direcciones)) {
		$direccionesTabla = 'No tienes ninguna dirección creada. <a class="boton-rojo" href="escritorio-direcciones-editar.php?accion=nueva">Nueva Dirección</a>';
	} else {
		$direccionesTabla = '<table class="tablaazul"><thead><tr><th>Calle</th><th>Código Postal</th><th>Ciudad</th><th>Provincia</th><th>País</th><th>Acciones</th></tr></thead>';
		foreach ($direcciones as $direccion) {
			$direccionesTabla .= '<tr><td>' . $direccion[2] . '</td><td>' . $direccion[3] . '</td><td>' . $direccion[4] . '</td><td>' . $direccion[5] . '</td><td>' . $direccion[6] . '</td><td><a href="escritorio-direcciones-editar.php?accion=editar&did=' . $direccion[0] . '" class="boton-rojo">Editar</a> <a href="escritorio-direcciones-borrar.php?did=' . $direccion[0] . '" class="boton-rojo">Eliminar</a></td></tr>';
		}
		$direccionesTabla .= '</table>';
	}
	return $direccionesTabla;
}

function direccionGuardar($accion, $direccion, $destino = 0) {
	if ($accion == 'nueva') {
		direccionGuardarNueva($direccion, $destino);
	} else {
		direccionGuardarEditar($direccion, $destino);
	}
}

function direccionEliminar($did, $destino) {
	direccionEliminarCons($did, $destino);
}

function direccionesTablaCarrito() {
	$direcciones = direccionesObtener($_SESSION['usuarioId']);
	if (empty($direcciones)) {
		$direccionesTabla = '<p>No tienes ninguna dirección creada. <a class="boton-rojo" href="escritorio-direcciones-editar.php?accion=nueva">Nueva Dirección</a></p>';
	} else {
		$direccionesTabla = '<form action="cart-total.php" method="post"><table class="tablaazul"><thead><tr><th>Seleccionar</th><th>Calle</th><th>Código Postal</th><th>Ciudad</th><th>Provincia</th><th>País</th></tr></thead>';
		foreach ($direcciones as $direccion) {
			$direccionesTabla .= '<tr><td><input type="radio" required value="' . $direccion[0] . '" name="direccionseleccionada"></td><td>' . $direccion[2] . '</td><td>' . $direccion[3] . '</td><td>' . $direccion[4] . '</td><td>' . $direccion[5] . '</td><td>' . $direccion[6] . '</td></tr>';
		}
		$direccionesTabla .= '</table>';
	}
	$direccionesTabla .= '<a href="cart.php" class="boton-darkred">Volver</a>&nbsp;<input type="submit" value="Ver total" /></form>';
	return $direccionesTabla;
}

function direccionesSelectPais($pais = 0) {
	$paises = [
		"Albania", "Alemania", "Andorra", "Armenia", "Austria", "Azerbaiyán", "Bélgica",
		"Bielorrusia", "Bosnia y Herzegovina", "Bulgaria", "Chipre", "Ciudad del Vaticano",
		"Croacia", "Dinamarca", "Eslovaquia", "Eslovenia", "España", "Estonia", "Finlandia",
		"Francia", "Georgia", "Grecia", "Hungría", "Irlanda", "Islandia", "Italia",
		"Kazajistán", "Letonia", "Liechtenstein", "Lituania", "Luxemburgo", "Malta",
		"Moldavia", "Mónaco", "Montenegro", "Noruega", "Países Bajos", "Polonia", "Portugal",
		"Reino Unido", "República Checa", "Macedonia del Norte", "Rumania", "Rusia",
		"San Marino", "Serbia", "Suecia", "Suiza", "Turquía", "Ucrania"
	];

	// Sort countries alphabetically
	sort($paises);

	$selectPais = '<select name="pais" class="carrito-cantidad pais" id="pais" onchange="toggleProvincia()">';
	foreach ($paises as $paisNombre) {
		$selectPais .= '<option value="' . $paisNombre . '" ' . ($pais == $paisNombre ? 'selected' : '') . '>' . $paisNombre . '</option>';
	}
	$selectPais .= '</select>';
	return $selectPais;
}


function direccionesSelectProvincia($provincia) {
	$provincias = [
		"Álava", "Albacete", "Alicante", "Almería", "Asturias", "Ávila", "Badajoz", "Baleares",
		"Barcelona", "Burgos", "Cáceres", "Cádiz", "Cantabria", "Castellón", "Ciudad Real",
		"Córdoba", "Cuenca", "Girona", "Granada", "Guadalajara", "Guipúzcoa", "Huelva",
		"Huesca", "Jaén", "La Coruña", "La Rioja", "Las Palmas", "León", "Lérida", "Lugo",
		"Madrid", "Málaga", "Murcia", "Navarra", "Orense", "Palencia", "Pontevedra", "Salamanca",
		"Segovia", "Sevilla", "Soria", "Tarragona", "Santa Cruz de Tenerife", "Teruel", "Toledo",
		"Valencia", "Valladolid", "Vizcaya", "Zamora", "Zaragoza"
	];

	// Sort provinces alphabetically
	sort($provincias);
	if (in_array($provincia, $provincias) || $provincia == 'nueva')
		$selectProvincia = '<select name="provincia_espana" class="carrito-cantidad provincia_espana">';
	else
		$selectProvincia = '<select name="provincia_espana" class="carrito-cantidad provincia_espana" style="display:none">';
	foreach ($provincias as $prov) {
		$selectProvincia .= '<option value="' . $prov . '" ' . ($provincia == $prov ? 'selected' : '') . '>' . $prov . '</option>';
	}
	$selectProvincia .= '</select>';
	return $selectProvincia;
}

// PEDIDOS
function pedidoGuardar() {
	$carrito = json_decode($_SESSION['carrito'], true);

	$usuario = usuarioObtenerId($_SESSION['usuarioId']);

	for ($i = 0; $i < count($carrito); $i++) {
		$productoTmp = productoObtenerId($carrito[$i]['pid']);
		$carrito[$i]['precio'] = $productoTmp[4];
	}

	$pedido = array();
	$pedido['uid'] = $usuario[0];
	$pedido['did'] = $_SESSION['did'];
	$pedido['fpedido'] = date_format(date_create(), 'Y-m-d');
	$pedido['enviado'] = 0;
	$pedido['importe'] = $_SESSION['total'];
	$pedido['productos'] = $carrito;

	// Borramos carrito
	$_SESSION['carrito'] = json_encode([]);
	unset($_SESSION['did']);
	unset($_SESSION['total']);

	pedidoGuardarCons($pedido);

	$mail = new PHPMailer(true);

	try {
		$mail->isSMTP();
		$mail->Host = 'localhost';
		$mail->SMTPAuth = false;
		$mail->SMTPAutoTLS = false;
		$mail->Port = 1025;

		$mail->setFrom('peru@basketandbites.com', 'PeruBasketAndBites');
		$mail->addAddress($usuario[3], $usuario[1] . ' ' . $usuario[2]);

		$mail->isHTML(true);
		$mail->Subject = 'Nuevo pedido desde Peru Basket and Bites';
		$mail->Body    = 'Tu pedido ha sido recibido y estara muy pronto de camino!';

		$mail->preSend();

		$timestamp = date('Y-m-d_H-i-s');
		$uniqueId = uniqid();
		$filename = "./tmp/email_{$timestamp}_{$uniqueId}.eml";

		if (!file_exists('./tmp')) {
			mkdir('./tmp', 0777, true);
		}

		file_put_contents($filename, $mail->getSentMIMEMessage());
	} catch (Exception $e) {
		echo "Se ha producido un error al enviar el email.";
	}
}

function pedidoEliminar($pid) {
	return (pedidoEliminarCons($pid));
}

function pedidoEnviar($pid, $uid) {
	pedidoEnviarCons($pid);
	$mail = new PHPMailer(true);
	$usuario = usuarioObtenerId($uid);

	try {
		$mail->isSMTP();
		$mail->Host = 'localhost';
		$mail->SMTPAuth = false;
		$mail->SMTPAutoTLS = false;
		$mail->Port = 1025;

		$mail->setFrom('peru@basketandbites.com', 'PeruBasketAndBites');
		$mail->addAddress($usuario[3], $usuario[1] . ' ' . $usuario[2]);

		$mail->isHTML(true);
		$mail->Subject = 'Tu pedido de Peru Basket and Bites ha sido enviado';
		$mail->Body    = 'Felicidades! Tu pedido esta de camino! Espero que lo disfrutes.';

		$mail->preSend();

		$timestamp = date('Y-m-d_H-i-s');
		$uniqueId = uniqid();
		$filename = "./tmp/email_{$timestamp}_{$uniqueId}.eml";

		if (!file_exists('./tmp')) {
			mkdir('./tmp', 0777, true);
		}

		file_put_contents($filename, $mail->getSentMIMEMessage());
	} catch (Exception $e) {
		echo "Se ha producido un error al enviar el email.";
	}
	header('Location: pedidos.php');
	exit();
}

function pedidosTablaUsuario($uid) {
	$pedidos = pedidosUsuario($uid);
	$pedidosTabla = '';
	if (empty($pedidos)) {
		$pedidosTabla = 'No tienes ningún pedidos creado. <a class="boton-rojo" href="tienda.php">Visitar tienda</a>';
	} else {
		$pedidosTabla = '<table class="tablaazul"><thead><tr><th>Número</th><th>Productos</th><th>Importe</th><th>Fecha de pedido</th><th>Enviado</th><th>Fecha de envío</th></tr></thead>';
		foreach ($pedidos as $pedido) {
			$productos = json_decode(stripslashes($pedido[3]), true);
			$importe = 0;
			$pedidoTabla = '<table><thead><tr><td>Producto</td><td>Cantidad</td><td>Precio</td></tr></thread>';
			foreach ($productos as $producto) {
				$importe += $producto['cantidad'] * $producto['precio'];
				$nombreProducto = productoObtenerId($producto['pid']);
				$pedidoTabla .= '<tr><td>' . $nombreProducto[2] . '</td><td>' . $producto['cantidad'] . '</td><td>' . $producto['precio'] . '</td></tr>';
			}
			$pedidoTabla .= '</table>';
			$pedido[5] == 0 ? $enviado = 'Pendiente de envío' : $enviado = 'Enviado';
			$pedido[6] == '' ? $fenvio = '' : $fenvio = date_format(date_create($pedido[6]), 'd-m-Y');
			$pedidosTabla .= '<tr><td>' . $pedido[2] . '</td><td>' . $pedidoTabla . '</td><td>' . $importe . '&euro;</td><td>' . date_format(date_create($pedido[4]), 'd-m-Y') . '</td><td>' . $enviado . '</td><td>' . $fenvio . '</td></tr>';
		}
		$pedidosTabla .= '</table>';
	}
	return $pedidosTabla;
}

function buscar($q) {
	return buscarConsulta($q);
}
