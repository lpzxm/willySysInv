<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }

    .welcome-container {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .welcome-card {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
    }

    .welcome-card h1 {
        color: #007bff;
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .welcome-card p {
        color: #6c757d;
        font-size: 1rem;
        margin-bottom: 30px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>

<div class="welcome-container">
    <div class="welcome-card">
        <h1>Bienvenido al Sistema de Inventario</h1>
        <p>Accede al sistema para gestionar el inventario de la empresa de manera eficiente y segura. Solo administradores y empleados autorizados tienen acceso.</p>
        <a href="?view=login" class="btn btn-primary btn-block" id="btn-gotoLogin">Iniciar sesión</a>
    </div>
</div>