<?php
include 'admin/funciones.php';

if (isset($_SESSION['usuarioId']) && $_SESSION['usuarioId'] != 0) {
    // Usuario conectado. Redirigimos a zona privada.
    header('Location: escritorio.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mi Cuenta - Peru'sBasketandBites</title>
    <?php include('head.php'); ?>
    <style>
        /* Basic styling for the tabs and forms */
        .tab-contenedor {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .tab {
            cursor: pointer;
            padding: 10px 20px;
            margin: 0 5px;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .tab.activo {
            background-color: #ccc;
        }

        .form-container {
            display: none;
        }

        .form-container.activo {
            display: block;
        }

        /* Center the form */
        .form-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
    <script>
        function showForm(formId) {
            // Ocultamos los formularios.
            const forms = document.querySelectorAll('.form-container');
            forms.forEach(form => form.classList.remove('activo'));

            // Quitamos la clase activo de todos los tabs.
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('activo'));

            // Mostramos el tab seleccionado.
            document.getElementById(formId).classList.add('activo');

            // Asignamos la clase activo al tab seleccionado
            if (formId === 'loginForm') {
                document.getElementById('loginTab').classList.add('activo');
            } else if (formId === 'registerForm') {
                document.getElementById('registerTab').classList.add('activo');
            }
        }
    </script>
</head>

<body id="basketandbites">
    <header class="header-container">
        <?php include('nav.php'); ?>
    </header>
    <main>
        <?php include('menu.php');
        ?>
        <div class="inicio">
            <div id="loginRegisterContainer">
                <div class="tab-contenedor">
                    <div class="tab activo" id="loginTab" onclick="showForm('loginForm')">Acceder</div>
                    <div class="tab" id="registerTab" onclick="showForm('registerForm')">Registrarse</div>
                </div>

                <div class="form-container activo" id="loginForm">
                    <form action="login.php" method="post">
                        <h2>Acceder</h2>
                        <input type="text" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="submit" value="Acceder">
                    </form>
                </div>

                <div class="form-container" id="registerForm">
                    <form action="register.php" method="post">
                        <h2>Nueva Cuenta</h2>
                        <input type="text" name="nombre" placeholder="Nombre" required>
                        <input type="text" name="apellidos" placeholder="Apellidos" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="text" name="telefono" placeholder="Telefono">
                        <input type="password" name="password" placeholder="Contraseña" required>
                        <input type="submit" value="Registrar">
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include('footer.php');
        ?>
    </footer>

</body>

</html>