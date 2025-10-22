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
    if ($_POST['accion'] == 'nuevo') {
        // Creamos el nuevo usuario admin
        usuarioGuardar($_POST);
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

        print '<h1>Instalar sitio web</h1>';
        print '<p>' . instalar() . '</p>';
        ?>
        <h2>Crear cuenta de administrador</h2>
        <form action="" method="post">
            <input type="text" placeholder="Nombre" name="nombre" required /><br />
            <input type="text" placeholder="Apellidos" name="apellidos" required /><br />
            <input type="email" placeholder="Email" name="email" required /><br />
            <input type="text" placeholder="Telefono" name="telefono" /><br />
            <input type="password" placeholder="Contraseña" name="password" required /><br />
            <input type="hidden" name="rol" value="admin" />
            <input type="hidden" name="accion" value="nuevo" />
            <input type="hidden" name="destino" value="instalar" />
            <input type="submit" value="Crear usuario" />
        </form>
    </main>
</body>

</html>