<?php
// Comprobamos si el usuario existe
include 'admin/funciones.php';

$usuario['nombre'] = $_POST['nombre'];
$usuario['apellidos'] = $_POST['apellidos'];
$usuario['email'] = $_POST['email'];
$usuario['telefono'] = $_POST['telefono'];
$usuario['password'] = $_POST['password'];
$usuario['rol'] = 'cliente';
$usuario['destino'] = 'micuenta';

usuarioGuardar($usuario);
