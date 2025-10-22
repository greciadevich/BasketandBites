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

if (isset($_POST['accion']) && $_POST['accion'] == 'login') {
    // Comprobamos que el usuario esta registrado
    if ($uid = comprobarUsuario($_POST['email'], $_POST['password'])) {
        print $uid;
    } else {
        print 'Usuario o contraseña incorrectos.';
    }
}
?>
<html>

<head>
    <title></title>
    <link rel="stylesheet" href="admin-styles.css">
</head>

<body>
    <main>
        <?php
        include('admin-header.php');

        // Comprobamos si existe usuarioRol en la sesion. Si existe, el usuario ya esta conectado.
        // Si no lo esta, mostramos el formulario.
        if (isset($_SESSION['usuarioRol'])) {
            print 'Mensaje de bienvenida';
        } else {
        ?>
            <form action="" method="POST">
                <input type="text" name="email" placeholder="Dirección de email" /><br />
                <input type="password" name="password" placeholder="Password" /><br />
                <input type="hidden" name="accion" value="login" />
                <input type="submit" value="Entrar" />
            </form>
        <?php
        }
        ?>
    </main>
</body>

</html>