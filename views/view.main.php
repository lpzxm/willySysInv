<?php
?>

<style>
    .card:hover {
        transform: scale(1.05);
        transition: transform 0.2s;
    }

    .icon {
        font-size: 3rem;
        color: #ffffff;
    }

    .card-title {
        color: #ffffff;
    }
</style>

<div class="container mt-5">
    <h2 class="text-center mb-4">Bienvenido al Panel Administrativo - <?= $_SESSION['user_name'] ?></h2>
    <h5 class="text-center">Selecciona una acción para comenzar:</h5>

    <div class="row g-4">
        <!-- Gestión de Productos -->
        <div class="col-lg-4 col-md-6">
            <div class="card bg-success text-white text-center shadow">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h5 class="card-title">Gestión de Productos</h5>
                    <p class="card-text">Agregar, editar y eliminar productos del inventario.</p>
                    <a href="?view=main/gestionarProductos" class="btn btn-light gsap-link">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Usuarios -->
        <div class="col-lg-4 col-md-6">
            <div class="card bg-warning text-white text-center shadow">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 class="card-title">Gestión de Usuarios</h5>
                    <p class="card-text">Administrar usuarios autorizados del sistema.</p>
                    <a href="?view=main/gestionarUsuarios" class="btn btn-light gsap-link">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Solicitud -->
        <div class="col-lg-4 col-md-6">
            <div class="card bg-danger text-white text-center shadow">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="bi bi-bar-chart"></i>
                    </div>
                    <h5 class="card-title">Estadisticas Generales</h5>
                    <p class="card-text">Visualizar estadísticas principales y generales del sistema</p>
                    <a href="?view=main/estadisticasGenerales" class="btn btn-warning">EN DESARROLLO</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Categorías -->
        <div class="col-lg-4 col-md-6">
            <div class="card bg-info text-white text-center shadow">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="bi bi-tags"></i>
                    </div>
                    <h5 class="card-title">Gestión de Categorías</h5>
                    <p class="card-text">Organizar productos en categorías.</p>
                    <a href="?view=main/gestionarCategorias" class="btn btn-light gsap-link">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Historial -->
        <div class="col-lg-4 col-md-6">
            <div class="card bg-secondary text-white text-center shadow">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h5 class="card-title">Historial</h5>
                    <p class="card-text">Consultar el historial de movimientos.</p>
                    <a href="#" class="btn btn-warning">EN DESARROLLO</a>
                </div>
            </div>
        </div>

        <!-- Marcas -->
        <div class="col-lg-4 col-md-6">
            <div class="card bg-dark text-white text-center shadow">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="bi bi-gear"></i>
                    </div>
                    <h5 class="card-title">Gestion de Marcas</h5>
                    <p class="card-text">Gestiona o visualiza las marcas registradas dentro del sistema y sus productos.</p>
                    <a href="?view=main/gestionarMarcas" class="btn btn-light gsap-link">Acceder</a>
                </div>
            </div>
        </div>
    </div>
</div>