<?php
// Comprobamos si el usuario y contrasena coinciden
include 'admin/funciones.php';
if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (comprobarUsuario($email, $password)) {
        header('Location: escritorio.php');
        exit();
    } else {
        mensajeAlerta('Usuario o contraseña no válidos.');
        header('Location: micuenta.php');
        exit();
    }
} else {
    mensajeAlerta('Usuario o contraseña no válidos.');
    header('Location: micuenta.php');
    exit();
}
