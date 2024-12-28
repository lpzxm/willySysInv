<style>
    /* Estilo para el footer */
    footer {
        background-color: #343a40;
        color: white;
        padding: 40px 0;
        margin-top: 40px;
    }

    footer h5 {
        color: #f8f9fa;
        font-size: 1.25rem;
        margin-bottom: 20px;
    }

    footer p {
        color: #adb5bd;
    }

    .social-icons a {
        color: white;
        margin-right: 15px;
        font-size: 1.5rem;
    }

    .social-icons a:hover {
        color: #007bff;
    }

    .footer-links a {
        color: #adb5bd;
        text-decoration: none;
    }

    .footer-links a:hover {
        color: #f8f9fa;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .social-icons {
            text-align: center;
            margin-top: 20px;
        }

        .footer-links {
            text-align: center;
            margin-top: 20px;
        }
    }
</style>

<!-- Footer -->
<footer class="text-center text-lg-start">
    <div class="container">
        <div class="row">
            <!-- Columna de Información -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5>Sistema de Inventario</h5>
                <p>Gestiona y organiza el inventario de forma rápida y eficiente. Fácil acceso para administradores y empleados autorizados.</p>
            </div>

            <!-- Columna de Enlaces -->
            <div class="col-lg-4 col-md-6 mb-4 footer-links">
                <h5>Enlaces</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Productos</a></li>
                </ul>
            </div>
        </div>

        <!-- Línea Separadora -->
        <hr class="my-4">

        <!-- Copyright -->
        <p>&copy; <?php echo date('Y'); ?> Sistema de Inventario Willy's. Todos los derechos reservados.</p>
    </div>
</footer>