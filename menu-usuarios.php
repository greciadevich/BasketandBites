<script>
    document.addEventListener('DOMContentLoaded', function() {
        var urlActual = window.location.href;

        var menuItems = document.querySelectorAll('.menu-padre');

        menuItems.forEach(function(menuItem) {
            var enlacePrimerNivel = menuItem.querySelector('a');

            if (enlacePrimerNivel && enlacePrimerNivel.href === urlActual) {
                menuItem.classList.add('active');
            } else {
                var enlacesAnidados = menuItem.querySelectorAll('.menu-hijo a');
                enlacesAnidados.forEach(function(enlaceAnidado) {
                    if (enlaceAnidado.href === urlActual) {
                        menuItem.classList.add('active');
                    }
                });
            }
        });
    });
</script>
<style>
    .active {
        font-weight: bold;
    }

    .active ul.menu-hijo {
        height: auto;
    }
</style>
<h2>Menú de usuario</h2>
<ul>
    <li class="menu-padre"><span><a href="escritorio-pedidos.php">Pedidos</a></span></li>
    <li class="menu-padre"><span><a href="escritorio-direcciones.php">Direcciones</a></span>
        <ul class="menu-hijo">
            <li><a href="escritorio-direcciones-editar.php?accion=nueva">Nueva Dirección</a></li>
        </ul>
    </li>
    <li class="menu-padre"><span><a href="escritorio-datos.php">Datos</a></span></li>
    <li class="menu-padre"><a href="logout.php"><span>Desconectar</span></a></li>
</ul>