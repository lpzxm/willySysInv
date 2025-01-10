<style>
    /* Personalización de estilos */
    .navbar {
        background-color: #007bff;
        padding: 20px;
    }

    .navbar-brand {
        font-size: 1.5rem;
        color: white !important;
        margin-left: 3vh;
    }

    .navbar-nav .nav-link {
        color: white !important;
    }

    .navbar-nav .nav-link:hover {
        color: #f8f9fa !important;
    }

    .dropdown-menu {
        background-color: #007bff;
    }

    .dropdown-item {
        color: white;
    }

    .dropdown-item:hover {
        background-color: #0056b3;
    }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="<?= (isset($_SESSION['user_id'])) ? "?view=main" : "?view=" ?>">Sistema Inventario</a>

    <?php
    if (isset($_SESSION['user_id'])) {
    ?>
        <?php
        if ($_SESSION['type'] === 'admin') {
        ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" style="margin-right: 5vh;">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="?view=main">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Funciones Administrativas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="?view=main/gestionarUsuarios">Usuarios</a></li>
                            <li><a class="dropdown-item" href="?view=main/gestionarProductos">Productos</a></li>
                            <li><a class="dropdown-item" href="?view=main/gestionarCategorias">Categorias</a></li>
                            <li><a class="dropdown-item" href="?view=main/gestionarMarcas">Marcas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Estadísticas</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="#">Historial</a></li>
                            <li><a class="dropdown-item" href="../config/process/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        <?php
        } else {
            //otra parte del menu para empleados, el de arriba es del admin xd
        ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" style="margin-right: 5vh;">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="?view=main">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Servicios</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="#">Configuración</a></li>
                            <li><a class="dropdown-item" href="../config/process/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        <?php } ?>

    <?php } ?>
</nav>

<?php if (isset($_SESSION['user_id'])) {
    echo "<button type='button' id='goBack'>Regresar</button>";
} ?>

<script>
    $("#goBack").click(function() {
        window.history.go(-1);
        return false;
    });
</script>